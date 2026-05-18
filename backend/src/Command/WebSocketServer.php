<?php

namespace App\Command;

use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand(
    name: 'app:websocket-server',
    description: 'Lance le serveur WebSocket pour la messagerie temps réel'
)]
class WebSocketServer extends Command
{
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $output->writeln('<info>🚀 Serveur WebSocket MarketHub démarré sur ws://localhost:8080</info>');
        
        $socket = stream_socket_server("tcp://0.0.0.0:8080", $errno, $errstr);
        
        if (!$socket) {
            $output->writeln("<error>Erreur: $errstr ($errno)</error>");
            return Command::FAILURE;
        }

        $clients = [];
        $output->writeln('<info>En attente de connexions...</info>');

        while (true) {
            $read = array_merge([$socket], $clients);
            $write = null;
            $except = null;

            if (stream_select($read, $write, $except, 0, 200000) === false) {
                break;
            }

            if (in_array($socket, $read)) {
                $client = stream_socket_accept($socket);
                $clients[] = $client;
                $output->writeln('<comment>✅ Nouveau client connecté</comment>');
                
                $request = fread($client, 1500);
                preg_match('#Sec-WebSocket-Key: (.*)\r\n#', $request, $matches);
                if (isset($matches[1])) {
                    $key = base64_encode(sha1(trim($matches[1]) . '258EAFA5-E914-47DA-95CA-C5AB0DC85B11', true));
                    $response = "HTTP/1.1 101 Switching Protocols\r\n";
                    $response .= "Upgrade: websocket\r\n";
                    $response .= "Connection: Upgrade\r\n";
                    $response .= "Sec-WebSocket-Accept: $key\r\n\r\n";
                    fwrite($client, $response);
                }
                unset($read[array_search($socket, $read)]);
            }

            foreach ($read as $client) {
                $data = fread($client, 1500);
                if (!$data) {
                    unset($clients[array_search($client, $clients)]);
                    fclose($client);
                    $output->writeln('<comment>❌ Client déconnecté</comment>');
                    continue;
                }

                $message = $this->decodeWebSocket($data);
                if ($message) {
                    $output->writeln("<info>Message reçu: $message</info>");
                    foreach ($clients as $c) {
                        fwrite($c, $this->encodeWebSocket("📨 " . $message));
                    }
                }
            }
        }

        return Command::SUCCESS;
    }

    private function decodeWebSocket(string $data): ?string
    {
        $length = ord($data[1]) & 127;
        if ($length == 126) {
            $masks = substr($data, 4, 4);
            $content = substr($data, 8);
        } else if ($length == 127) {
            $masks = substr($data, 10, 4);
            $content = substr($data, 14);
        } else {
            $masks = substr($data, 2, 4);
            $content = substr($data, 6);
        }
        $text = '';
        for ($i = 0; $i < strlen($content); ++$i) {
            $text .= $content[$i] ^ $masks[$i % 4];
        }
        return $text ?: null;
    }

    private function encodeWebSocket(string $text): string
    {
        $length = strlen($text);
        if ($length <= 125) {
            return "\x81" . chr($length) . $text;
        } else if ($length <= 65535) {
            return "\x81\x7E" . pack('n', $length) . $text;
        } else {
            return "\x81\x7F" . pack('J', $length) . $text;
        }
    }
}