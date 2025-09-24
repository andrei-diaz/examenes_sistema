<?php
declare(strict_types=1);

namespace App\Controller;

class PagesController extends AppController
{
    public function dashboard()
    {
        $user = $this->Authentication->getIdentity();

        // Cargar estadísticas según el rol
        if ($user->role === 'administrador') {
            $usersTable = $this->fetchTable('Users');
            $reactivosTable = $this->fetchTable('Reactivos');

            $totalUsers = $usersTable->find()->count();
            $totalReactivos = $reactivosTable->find()->count();
            $reactivosPorEspecialidad = $reactivosTable->find()
                ->select(['area_especialidad', 'count' => $reactivosTable->find()->func()->count('*')])
                ->groupBy('area_especialidad')
                ->toArray();

            $this->set(compact('totalUsers', 'totalReactivos', 'reactivosPorEspecialidad'));
        } else {
            $reactivosTable = $this->fetchTable('Reactivos');
            $misReactivos = $reactivosTable->find()
                ->where(['user_id' => $user->id])
                ->count();
            $this->set(compact('misReactivos'));
        }

        $this->set(compact('user'));
    }
}