<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ConferenceController extends AbstractController
{
    /**
     * @Route("/hello/{name}", name="conference")
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request, string $name)
    {
        $greet = '';

        if ($name) {
            $greet = sprintf('<h1>Hello %s</h1>', htmlspecialchars($name)) ;
        }

        return new Response(<<<EOF
<html lang="ua">
    <body>
        $greet
        <img src="/images/under_construction.png"  alt="under_construction"/>
    </body>
</html>
EOF
        );


        return $this->render('conference/index.html.twig', [
            'controller_name' => 'ConferenceController',
        ]);

    }
}
