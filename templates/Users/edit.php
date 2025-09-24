<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\User $user
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Form->postLink(
                __('Eliminar'),
                ['action' => 'delete', $usuario->id],
                ['confirm' => __('¿Estás seguro de que quieres eliminar el usuario #{0}?', $usuario->id), 'class' => 'side-nav-item']
            ) ?>
            <?= $this->Html->link(__('Lista de Usuarios'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column column-80">
        <div class="users form content">
            <?= $this->Form->create($usuario) ?>
            <fieldset>
                <legend><?= __('Editar Usuario') ?></legend>
                <?php
                    echo $this->Form->control('email', [
                        'label' => 'Correo Electrónico',
                        'type' => 'email',
                        'required' => true
                    ]);
                    echo $this->Form->control('password', [
                        'label' => 'Contraseña',
                        'type' => 'password',
                        'value' => '', // Limpiar campo de contraseña por seguridad
                        'placeholder' => 'Dejar en blanco para mantener la contraseña actual',
                        'required' => false
                    ]);
                    echo $this->Form->control('role', [
                        'label' => 'Rol',
                        'type' => 'select',
                        'options' => [
                            'administrador' => 'Administrador',
                            'usuariobase' => 'Usuario Base'
                        ],
                        'empty' => 'Selecciona un rol',
                        'required' => true
                    ]);
                    echo $this->Form->control('active', [
                        'label' => 'Estado',
                        'type' => 'select',
                        'options' => [
                            1 => 'Activo',
                            0 => 'Inactivo'
                        ],
                        'required' => true
                    ]);
                ?>
            </fieldset>
            <?= $this->Form->button(__('Submit')) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>
