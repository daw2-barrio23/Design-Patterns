<?php


// Clase base para elementos del sistema de archivos
abstract class FileSystemItem {
    private $name;


    public function setName($name) {
        $this->name = $name;
    }


    public function getName() {
        return $this->name;
    }


    abstract public function getDescription();
}


// Clase para carpetas
class Folder extends FileSystemItem {
    private $files = array();


    public function __construct($name){
        parent::setName($name);
    }


    public function add(FileSystemItem $file){
        array_push($this->files, $file);
    }


    public function remove(FileSystemItem $file){
        array_pop($this->files);
    }


    public function hasChildren(){
        return (bool)(count($this->files) > 0);
    }


    public function getChild($i){
        return $this->files[$i];
    }


    public function getDescription(){
        echo "one " . $this->getName();
        if ($this->hasChildren()){
            echo " which includes: <br>";
            foreach($this->files as $file){
                $file->getDescription();
                echo "<br>";
            }
        }
    }
}


// Clase para archivos
class File extends FileSystemItem {
    public function __construct($name){
        parent::setName($name);
    }


    public function getDescription(){
        echo $this->getName();
    }
}


// Clase para enlaces suaves
class Link extends FileSystemItem {
    private $isSoftLink;
    private $linksTo;


    public function __construct($name, $isSoftLink, $linksTo){
        parent::setName($name);
        // Esto son los atributos específicos
        $this->isSoftLink = $isSoftLink;
        $this->linksTo = $linksTo;
    }


    public function getIsSoftLink() {
        return $this->isSoftLink;
    }


    public function getDescription(){
        echo $this->getName();
    }
}


$folder1 = new Folder("carpeta 1");
$file1 = new File("hola mundo");
$link1 = new Link("mi enlace", true, "ruta/al/enlace");


$folder1->add($file1);
$folder1->add($link1);


$folder2 = new Folder("carpeta 2");
$file2 = new File("archivo 1");
$file3 = new File("archivo 2");


$folder2->add($file2);
$folder2->add($file3);


echo "Listado de Carpeta 1: ";
$folder1->getDescription();
echo "<br>";


echo "Listado de Carpeta 2: ";
$folder2->getDescription();


echo "<br>";
// Mostrar el booleano isSoftLink
echo "Es un soft link: " . ($link1->getIsSoftLink() ? "Sí" : "No");
?>
