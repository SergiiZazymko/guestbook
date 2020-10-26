<?php

namespace App\Controller;

use App\Entity\Conference;
use App\Repository\CommentRepository;
use App\Repository\ConferenceRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Twig\Environment;

class ConferenceController extends AbstractController
{
    /**
     * @var Environment
     */
    private $twig;

    /**
     * ConferenceController constructor.
     *
     * @param Environment $twig
     */
    public function __construct(Environment $twig)
    {
        $this->twig = $twig;
    }

    /**
     * @Route("/hello/{name}", name="conference_list")
     *
     * @param Request $request
     * @return Response
     */
    public function index(
//        Request $request,
//        string $name,
        ConferenceRepository $conferenceRepository
    ) {
//        $greet = '';
//
//        if ($name) {
//            $greet = sprintf('<h1>Hello %s</h1>', htmlspecialchars($name)) ;
//        }

//        return new Response(<<<EOF
//<html lang="ua">
//    <body>
//        $greet
//        <img src="/images/under_construction.png"  alt="under_construction"/>
//    </body>
//</html>
//EOF
//        );

//        return $this->render('conference/index.html.twig', [
//            'controller_name' => 'ConferenceController',
//            'conferences' => $conferenceRepository->findAll(),
//        ]);

        return new Response($this->twig->render('conference/index.html.twig', [
            'controller_name' => 'ConferenceController',
            'conferences' => $conferenceRepository->findAll(),
        ]));
    }

    /**
     * @Route("/conference/{id}", name="conference")
     */
    public function show(
        Request $request,
        Conference $conference,
        CommentRepository $commentRepository
    ) {
        $offset = max(0, $request->query->getInt('offset', 0));

        $paginator = $commentRepository->getCommentPaginator($conference, $offset);

        return new Response($this->twig->render('conference/show.html.twig', [
            'conference' => $conference,
            //'comments' => $commentRepository->findBy(['conference' => $conference], ['createdAt' => 'DESC']),
            'comments' => $paginator,
            'previous' => $offset - CommentRepository::PAGINATOR_PER_PAGE,
            'next' => $offset + CommentRepository::PAGINATOR_PER_PAGE,
        ]));
    }
}
