<?php

require_once("src/Repository/EntityRepository.php");
require_once("src/Class/Category.php");


/**
 *  Classe CategoryRepository
 * 
 *  Cette classe représente le "stock" de Category.
 *  Toutes les opérations sur les Category doivent se faire via cette classe 
 *  qui tient "synchro" la bdd en conséquence.
 * 
 *  La classe hérite de EntityRepository ce qui oblige à définir les méthodes  (find, findAll ... )
 *  Mais il est tout à fait possible d'ajouter des méthodes supplémentaires si
 *  c'est utile !
 *  
 */
class CategoryRepository extends EntityRepository {

    public function __construct(){
        // appel au constructeur de la classe mère (va ouvrir la connexion à la bdd)
        parent::__construct();
    }

    public function find($id): ?Category{
        /*
            La façon de faire une requête SQL ci-dessous est "meilleur" que celle vue
            au précédent semestre (cnx->query). Notamment l'utilisation de bindParam
            permet de vérifier que la valeur transmise est "safe" et de se prémunir
            d'injection SQL.
        */
        $requete = $this->cnx->prepare('SELECT * FROM "Category" WHERE id=:value'); // prepare la requête SQL
        $requete->bindParam(':value', $id); // fait le lien entre le "tag" :value et la valeur de $id
        $requete->execute(); // execute la requête
        $answer = $requete->fetch(PDO::FETCH_OBJ);
        
        if ($answer==false) return null; // may be false if the sql request failed (wrong $id value for example)
        
        $p = new Category($answer->id);
        $p->setName($answer->name);
    
        return $p;
    }

    public function findAll(): array {
        $requete = $this->cnx->prepare('SELECT * FROM "Category"');
        $requete->execute();
        $answer = $requete->fetchAll(PDO::FETCH_OBJ);

        $res = [];
        foreach($answer as $obj){
            $p = new Category($obj->id);
            $p->setName($obj->name);
            
            array_push($res, $p);
        }
       
        return $res;
    }


    public function save($category){
        $requete = $this->cnx->prepare('INSERT INTO "Category" (name) VALUES (:name) RETURNING id');
        $name = $category->getName();
       
        $requete->bindParam(':name', $name );
        $requete->execute();
        $category->setId((int) $requete->fetchColumn());
        return true;
    }

    public function delete($id){
        // Not implemented ! TODO when needed !
        return false;
    }

    public function update($category){
        // Not implemented ! TODO when needed !
        return false;
    }

   
    
}