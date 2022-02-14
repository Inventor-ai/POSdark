<?php

namespace App\Entities;

use CodeIgniter\Entity\Entity;

class User extends Entity
{
  // $usuario = $UsuariosModel->find($id);
  public function setPassword(String $pass)
  {
    $this->attributes['password'] = password_hash($pass, PASSWORD_BCRYPT);
    // $this->attributes['password'] = $pass ? password_hash($pass, PASSWORD_BCRYPT) : $pass;
                                                             //  PASSWORD_DEFAULT);
    // $this->attributes['password'] = $pass;
    return $this;
  }  

}
