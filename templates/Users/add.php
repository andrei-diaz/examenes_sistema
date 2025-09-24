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
            <?= $this->Html->link(__('List Users'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column column-80">
        <div class="users form content">
            <?= $this->Form->create($usuario) ?>
            <fieldset>
                <legend><?= __('Agregar Usuario') ?></legend>
                <?php
                    echo $this->Form->control('email', [
                        'label' => 'Correo Electrónico',
                        'type' => 'email',
                        'required' => true
                    ]);
                    echo $this->Form->control('password', [
                        'label' => 'Contraseña',
                        'type' => 'password',
                        'required' => true
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
                        'default' => 1,
                        'required' => true
                    ]);
                ?>
            </fieldset>
            <?= $this->Form->button(__('Submit')) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>
