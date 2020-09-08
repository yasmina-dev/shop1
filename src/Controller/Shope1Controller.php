<?php

namespace App\Controller;


use App\Entity\Product;
use Doctrine\ORM\EntityManagerInterface;
use phpDocumentor\Reflection\Type;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

/**
 * @route("/api")
 */
class Shope1Controller extends AbstractController
    /**
     * @route ("/produit",name="creation","methode"={"POST"}
     */
{
    public function creation(
        Request $request,
        SerializerInterface $serializer,
        ValidatorInterface $validator,
        EntityManagerInterface $entityManager)
    {
        $data = $request->getContent();
        $objet = $serializer->deserialize($data,

            Product::class, "json",
            [ObjectNormalizer::DISABLE_TYPE_ENFORCEMENT => true]);


        $errors = $validator->validate($objet);


        if ($errors->count() > 0) {

            return $this->json("il y'a des erreurs", 404);
        }

        $entityManager->persist($objet);
        $entityManager->flush();

        return $this->json($objet, 201);

    }
}

