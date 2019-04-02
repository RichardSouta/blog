<?php
declare(strict_types=1);

namespace AppBundle\Controller;

use AppBundle\Entity\BlogPost;
use Doctrine\ORM\EntityManagerInterface;
use Pagerfanta\Adapter\DoctrineORMAdapter;
use Pagerfanta\Pagerfanta;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class BlogController extends Controller
{
    private $em;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->em = $entityManager;
    }

    /**
     * @param Request $request
     * @return Response
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request): Response
    {
        $page = $request->query->getInt('page', 1);
        $queryBuilder = $this->em->createQueryBuilder()
            ->select('bp')
            ->from(BlogPost::class, 'bp')
            ->where('bp.hidden = false');
        $adapter = new DoctrineORMAdapter($queryBuilder);
        $pagerfanta = new Pagerfanta($adapter);
        $pagerfanta->setMaxPerPage(2)->setCurrentPage($page);
        $blogPosts = $this->em->getRepository(BlogPost::class)->findBy(['hidden' => false], ['date' => 'desc'], 2, ($page - 1) * 2);
        return $this->render('default/index.html.twig', [
            'pager' => $pagerfanta,
            'blogPosts' => $blogPosts,
        ]);
    }

    /**
     * @param Request $request
     * @param int $id
     * @return Response
     * @Route("/{id}", name="detail")
     */
    public function showAction(Request $request, int $id): Response
    {
        /** @var BlogPost $blogPost */
        $blogPost = $this->em->getRepository(BlogPost::class)->findOneBy(['id' => $id, 'hidden' => false]);
        if ($blogPost !== null) {
            $blogPost->increaseViewsCount();
            $this->em->flush();
            return $this->render('default/show.html.twig', [
                'blogPost' => $blogPost,
            ]);
        }
        throw $this->createNotFoundException('The blog post does not exist!');
    }
}
