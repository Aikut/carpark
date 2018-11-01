<?php

namespace Application\Sonata\MediaBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

class MediaController extends Controller
{
    public function deleteMediaAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $media = $em->getRepository('ApplicationSonataMediaBundle:Media')->find($id);
        $entities = array();
        $array = array();
        $entities['gallery_media'] = 'GalleryBundle:GalleryHasMedia';
        $array[$media->getContext()] = 'does not have gallery';
        if (array_intersect_key($entities, $array))
            $entity = $em->getRepository($entities[$media->getContext()])->findOneByMedia($media);
        else
            $entity = $media;
        if($entity){
            $em->remove($entity);
            $em->flush();
            return new Response(1);
        }
        return new Response(0);
    }

}
