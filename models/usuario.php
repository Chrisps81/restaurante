<?php

class Usuario{

    private $id;
    private $nombre;
    private $apellidos;
    private $email;
    private $password;
    private $rol;
    private $imagen;
    private $fecha_alta;
    private $fecha_modi;
    private $estado;
    private $db;
    
    public function __construct(){
        $this->db =  Database::connect();
    }

    /**
     * @return mixed
     */
    function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     * @return Usuario
     */
    function setId($id)
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return mixed
     */
    function getNombre(){
        return $this->nombre;
    }

    /**
     * @param mixed $nombre
     * @return Usuario
     */
    function setNombre($nombre)
    {
        $this->nombre = $this->db->real_escape_string($nombre);
    }

    /**
     * @return mixed
     */
    function getApellidos()
    {
        return $this->apellidos;
    }

    /**
     * @param mixed $apellidos
     * @return Usuario
     */
    function setApellidos($apellidos)
    {
        $this->apellidos = $this->db->real_escape_string($apellidos);
    }

    /**
     * @return mixed
     */
    function getEmail()
    {
        return $this->email;
    }

    /**
     * @param mixed $email
     * @return Usuario
     */
    function setEmail($email)
    {
        $this->email = $this->db->real_escape_string($email);
    }

    /**
     * @return mixed
     */
    function getPassword(){
        return password_hash($this->db->real_escape_string($this->password), PASSWORD_BCRYPT, ['cost' => 4]);
    }

    /**
     * @param mixed $password
     * @return Usuario
     */
    function setPassword($password){
        $this->password = $password;
    }

    /**
     * @return mixed
     */
    function getRol()
    {
        return $this->rol;
    }

    /**
     * @param mixed $rol
     * @return Usuario
     */
    function setRol($rol)
    {
        $this->rol = $rol;
    }

    /**
     * @return mixed
     */
    function getImagen()
    {
        return $this->imagen;
    }

    /**
     * @param mixed $imagen
     * @return Usuario
     */
    function setImagen($imagen)
    {
        $this->imagen = $imagen;
        return $this;
    }
    
    function getFecha_alta() {
        return $this->fecha_alta;
    }

    function getFecha_modi() {
        return $this->fecha_modi;
    }

    function getEstado() {
        return $this->estado;
    }

    function setFecha_alta($fecha_alta){
        $this->fecha_alta = $fecha_alta;
    }

    function setFecha_modi($fecha_modi){
        $this->fecha_modi = $fecha_modi;
    }

    function setEstado($estado) {
        $this->estado = $estado;
    }

    public function save(){
        $sql = "INSERT INTO usuarios VALUES (NULL, '{$this->getNombre()}', '{$this->getApellidos()}', '{$this->getEmail()}', '{$this->getPassword()}', 'user', null, NOW(), null, 0);";
        $save = $this->db->query($sql);

        $result = false;
        if($save){
            $result = true;
        }
        return $result;
    }
    
    public function login(){
        $result = false;
        $email = $this->email;
        $password = $this->password;
        
        // comprobar si existe usuario
        $sql = "SELECT * FROM usuarios WHERE email = '$email'";
        $login = $this->db->query($sql);
        
        if($login  && $login->num_rows == 1){
            $usuario = $login->fetch_object();
            
            //verificar la comtraseña
            $verify = password_verify($password, $usuario->password);
            
            if($verify){
                $result = $usuario;
            }
        }
        
        return $result;
    }
}