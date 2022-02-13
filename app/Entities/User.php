<?php

namespace App\Entities;

use CodeIgniter\Entity\Entity;

class User extends Entity
{
  // $usuario = $UsuariosModel->find($id);
  public function setPassword(String $pass)
  {
    $this->attributes['password'] = $pass ? password_hash($pass, PASSWORD_BCRYPT) : $pass;
    // $this->attributes['password'] = $pass;
    return $this;
  }  

}
