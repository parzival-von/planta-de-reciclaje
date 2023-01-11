<!DOCTYPE html>
<html>
<head>
<link rel="stylesheet" href="style.css">
</head>
<body>

<?php

session_start();
//1. Crea una class contenedor  que contenga las propiedades necesarias. 
class container{
    public $nombre;
    public $capacidad;
    public $basura;
// 2. Crea un método constructor en class contenedor 
    function __construct($n,$c){
        $this->nombre=$n;
        $this->capacidad=$c;
        $this->basura=0;
    }

    function obtNombre(){
        return $this->nombre;
    }
//4.    Crea un método function pintacontenedor  en class contenedor  que muestre el contenedor con su número de basuras y su capacidad. 
    function pintacontainer(){
        echo '<div style="float:left; height:80px" >';
        echo '<div style="float:left; width: 50px; height: 80px"><a href="index.php?container='.$this->nombre.'"><img src="'.$this->nombre.'.png" width="50px"></img></a><span>'.$this->basura.' / '.$this->capacidad.'</span></div>';
        echo '</div>';
    }
//3.    Crea un método function tirarbasura  en class contenedor  que sume uno a la cantidad del contenedor si no está lleno. 
    function tirarbasura(){
        if($this->basura < $this->capacidad){
            $this->basura++;
            return 1;
        }
        else return 0;
    }
    function vaciar(){
        $this->basura=0;
    }
}

function generabasura(){
    $basura=['glass','paper','plastic','organic'];
    return $basura[rand(0,3)];
}

// 5.    Piensa qué variables de sesión usarías, su inicialización y su uso. 

if(!isset($_SESSION['reciclaje'])){
    $_SESSION['contador']=0;
    $_SESSION['basura']=[];
    for ($i=0; $i<5; $i++) array_push($_SESSION['basura'], generabasura());
    $_SESSION['reciclaje']= [ 'paper'=>new container('paper', 5),
                                'glass'=>new container('glass', 6),
                                'plastic'=>new container('plastic', 7),
                                'organic'=>new container('organic', 7)];
}
// 7.    Escribe el código necesario para que al clicar sobre un contenedor se tire la próxima basura al contenedor (si se puede) 

if(isset($_REQUEST['container'])) {
        if ($_SESSION['reciclaje'][$_REQUEST['container']]->obtNombre() == $_SESSION['basura'][4]) {
            if ($_SESSION['reciclaje'][$_REQUEST['container']]->tirarbasura()) {
                array_pop($_SESSION['basura']);
                array_unshift($_SESSION['basura'], generabasura());
                $_SESSION['contador']++;
            }
        }
}

//8.Escribe el código necesario para que al clicar sobre el camión de la basura se vacíen los contenedores. 

if(isset($_REQUEST['vaciar'])){
    foreach ($_SESSION['reciclaje'] as $value) $value->vaciar();
}

// 6.Muestra todos los elementos en pantalla: todos los contenedores, contadores, basuras a tirar y camión de la basura. 

echo '<h1>Estación de reciclaje</h1><p> Basura Total: '. $_SESSION['contador'].'</p>';
foreach ($_SESSION['basura'] as $v) {
    echo '<div style="clear: both; height: 30px;">';
    echo $v;
    echo '</div>';
}
echo '<div style="clear: both; height: 60px;">';
foreach ($_SESSION['reciclaje'] as $r) {
    $r->pintacontainer();
}
echo '</div>';

echo '<a href="index.php?vaciar=1" style="float:left;"> <img src="camion.png" width="80px"></img> </a>';
?>
</body>
</html>