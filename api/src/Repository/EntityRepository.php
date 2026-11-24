<?php

/**
 *  Classe EntityRespository
 * 
 *  Classe abstraite ! Elle décrit la gestion d'une famille de ressources (produits, commandes, utilisateurs...)
 *  au niveau du système d'information (base de données).
 * 
 *  Quand on a une nouvelle famille de ressource à gérer, on créera une classe fille qui saura : 
 * 
 *  - trouver une ressource dans la base  (voir la méthode find)
 *  - trouver toutes les ressources  dans la base (voir la méthode findAll)
 *  - sauvegarder une ressource dans la base (voir la méthode save)
 *  - supprimer une ressource dans la base (voir la méthode delete)
 *  - mettre à jour une ressource dans la base (voir la méthode update)
 * 
 *  Exemple : voir la classe ProductRepository
 */
abstract class EntityRepository {
    protected $cnx;

    protected function __construct(){
        $host = getenv("DB_HOST");
        $port = getenv("DB_PORT") ?: "5432";
        $name = getenv("DB_NAME");
        $user = getenv("DB_USER");
        $password = getenv("DB_PASSWORD");

        if ($host === false || $host === "" || $name === false || $name === "" ||
            $user === false || $user === "" || $password === false || $password === "") {
            throw new RuntimeException("DB_HOST, DB_NAME, DB_USER and DB_PASSWORD must be configured");
        }

        $this->cnx = new PDO("pgsql:host={$host};port={$port};dbname={$name};sslmode=require", $user, $password, [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES => false,
        ]);
    }

    /**
     *  find
     *  Query the data base for the entity with id $id.
     *  Must return an Entity object or false if the query fails
     */
    abstract public function find($id);

    /**
     *  findAll
     *  Query the data base for all the entities
     *  Must return an array of Entity objects or false if the query fails
     */
    abstract public function findAll();

    /**
     *  save
     *  Save in the data base a new Entity object.
     *  Update the Entity object with its data base id.
     *  Must return true or false if it fails to save the object.
     */
    abstract public function save($entity);

    /**
     *  delete
     *  delete in the data base Entity object with id $id
     *  Must return true or false if it fails to delete the object.
     */
    abstract public function delete($id);

     /**
     *  udpate
     *  update in the data base Entity object $entity
     *  Must return true or false if it fails to delete the object.
     */
    abstract public function update($entity);
}