<?php
declare(strict_types=1);

namespace AppBundle\Controller\Api;

use AppBundle\Entity\BlogPost;
use Doctrine\ORM\EntityManagerInterface;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\Controller\Annotations as Http;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

/**
 * @Route("/api",name="api_posts_")
 */
class BlogController extends AbstractFOSRestController
{
    private $em;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->em = $entityManager;
    }

    /**
     * @param Request $request
     * @return JsonResponse
     * @Http\Get("/posts",name="index")
     */
    public function indexAction(Request $request): JsonResponse
    {
        /** @var BlogPost[] $blogPosts */
        $blogPosts = $this->em->getRepository(BlogPost::class)->findBy(['hidden' => false]);
        $body = [];
        foreach ($blogPosts as $blogPost) {
            $url = $this->generateUrl(
                'api_posts_show',
                [
                'id' => $blogPost->getId(),
                ],
                UrlGeneratorInterface::ABSOLUTE_URL
            );

            $bodyPart['title'] = $blogPost->getTitle();
            $bodyPart['date'] = $blogPost->getDate();
            $bodyPart['url'] = $url;
            $body[] = $bodyPart;
        }
        return new JsonResponse(['posts' => $body]);
    }

    /**
     * @param Request $request
     * @param int $id
     * @return JsonResponse
     * @Http\Get("/posts/{id}",name="show")
     */
    public function showAction(Request $request, int $id): JsonResponse
    {
        /** @var BlogPost $blogPost */
        $blogPost = $this->em->getRepository(BlogPost::class)->findOneBy(['id' => $id, 'hidden' => false]);
        if ($blogPost !== null) {
            $url = $this->generateUrl(
                'api_posts_show',
                [
                'id' => $blogPost->getId(),
                ],
                UrlGeneratorInterface::ABSOLUTE_URL
            );

            $blogPost->increaseViewsCount();
            $this->em->flush();// persist is not needed since tracking policy of BlogPost is deferred implicit by default
            $tags = [];
            foreach ($blogPost->getTags() as $tag) {
                $tags[] = $tag->getId();
            }
            $body = [
                'title' => $blogPost->getTitle(),
                'text' => $blogPost->getText(),
                'date' => $blogPost->getDate(),
                'tags' => $tags,
                'url' => $url,
            ];
            return new JsonResponse(['posts' => $body]);
        }
        return new JsonResponse(null, 204);
    }
}
