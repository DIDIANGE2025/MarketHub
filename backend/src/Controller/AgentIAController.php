<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/api/agent')]
class AgentIAController extends AbstractController
{
    private function simulerReponse(array $messages): string
    {
        $lastMessage = strtolower(end($messages)['content'] ?? '');

        if (str_contains($lastMessage, 'bonjour') || str_contains($lastMessage, 'salut') || str_contains($lastMessage, 'hello')) {
            return "👋 Salut ! Je suis ton conseiller formation MarketHub.\n\nQuel est ton domaine d'intérêt ?\n🖥️ Développement web\n🎨 Design UI/UX\n📣 Marketing digital\n✍️ Rédaction";
        }
        if (str_contains($lastMessage, 'dev') || str_contains($lastMessage, 'web') || str_contains($lastMessage, 'code')) {
            return "Super choix ! 🚀 Le développement web est très demandé.\n\nQuel est ton budget ?\n💰 Moins de 50€\n💰💰 Entre 50-100€\n💰💰💰 Plus de 100€";
        }
        if (str_contains($lastMessage, 'design') || str_contains($lastMessage, 'figma') || str_contains($lastMessage, 'ui')) {
            return "Excellent ! 🎨 Le design UI/UX est très recherché.\n\nQuel est ton budget ?\n💰 Moins de 50€\n💰💰 Entre 50-100€\n💰💰💰 Plus de 100€";
        }
        if (str_contains($lastMessage, 'market') || str_contains($lastMessage, 'seo') || str_contains($lastMessage, 'redact')) {
            return "Parfait ! 📣 Le marketing digital est très demandé.\n\nQuel est ton budget ?\n💰 Moins de 50€\n💰💰 Entre 50-100€\n💰💰💰 Plus de 100€";
        }
        if (str_contains($lastMessage, '50') || str_contains($lastMessage, '100') || str_contains($lastMessage, 'euro') || str_contains($lastMessage, 'budget')) {
            return "Super ! 💪 Combien de temps as-tu par semaine ?\n⏰ Moins de 5h\n⏰⏰ Entre 5-10h\n⏰⏰⏰ Plus de 10h";
        }
        if (str_contains($lastMessage, 'heure') || str_contains($lastMessage, '5h') || str_contains($lastMessage, '10h') || str_contains($lastMessage, 'temps') || str_contains($lastMessage, 'semaine')) {
            return "🎯 Voici ton parcours personnalisé MarketHub :\n\n📚 Semaine 1-2 : Cours de mathématiques (25€)\n💻 Semaine 3-4 : Création de site web (150€)\n✍️ Semaine 5-6 : Cours d'anglais (20€)\n\n💡 Budget total : 195€\n\n✨ Conseil : Commence par les bases, puis pratique avec la création de site. Tu seras opérationnel en 6 semaines ! 🚀";
        }

        return "👋 Salut ! Je suis ton conseiller formation MarketHub. Dis-moi ton domaine d'intérêt (développement, design, marketing, rédaction...) et je te construis un parcours personnalisé ! 🎯";
    }

    #[Route('/conseiller', name: 'agent_conseiller', methods: ['POST'])]
    public function conseiller(Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(), true);
        $messages = $data['messages'] ?? [];
        $reply = $this->simulerReponse($messages);
        return $this->json(['reply' => $reply]);
    }

    #[Route('/description', name: 'agent_description', methods: ['POST'])]
    public function description(Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(), true);
        $competences = $data['competences'] ?? '';
        $categorie = $data['categorie'] ?? '';
        $prix = $data['prix'] ?? '';

        $description = "Expert en $categorie avec des compétences solides en $competences. ";
        $description .= "Je vous propose un service professionnel et de qualité, livré dans les délais convenus. ";
        $description .= "Pour seulement {$prix} euros, bénéficiez d'un accompagnement personnalisé et de résultats concrets. ";
        $description .= "N'hésitez pas à me contacter pour discuter de votre projet ! 🚀";

        return $this->json(['description' => $description]);
    }

    #[Route('/matching', name: 'agent_matching', methods: ['POST'])]
    public function matching(Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(), true);
        $services = $data['services'] ?? [];

        $recommandations = [];
        foreach (array_slice($services, 0, 2) as $service) {
            $recommandations[] = [
                'id' => $service['id'],
                'raison' => 'Service adapté à votre besoin et budget',
                'score' => rand(80, 98)
            ];
        }

        return $this->json([
            'recommandations' => $recommandations,
            'conseil' => '💡 Ces services correspondent parfaitement à votre besoin. Commencez par le premier pour avoir des résultats rapides !'
        ]);
    }
}