<?php
/**
 * @var \App\View\AppView $this
 * @var iterable<\App\Model\Entity\User> $users
 */
?>

<div class="users index content">
    <h3>Gestión de Usuarios</h3>

    <div class="table-actions">
        <?= $this->Html->link(__('Crear Nuevo Usuario'), ['action' => 'add'], ['class' => 'button float-right']) ?>
    </div>

    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th><?= $this->Paginator->sort('id', 'ID') ?></th>
                    <th><?= $this->Paginator->sort('email', 'Email') ?></th>
                    <th><?= $this->Paginator->sort('role', 'Rol') ?></th>
                    <th><?= $this->Paginator->sort('active', 'Estado') ?></th>
                    <th>Reactivos</th>
                    <th><?= $this->Paginator->sort('created', 'Fecha Registro') ?></th>
                    <th class="actions"><?= __('Acciones') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($users as $user): ?>
                <tr>
                    <td><?= $this->Number->format($user->id) ?></td>
                    <td><?= h($user->email) ?></td>
                    <td>
                        <span class="badge badge-role-<?= $user->role ?>">
                            <?= $user->role === 'administrador' ? 'Administrador' : 'Usuario Base' ?>
                        </span>
                    </td>
                    <td>
                        <span class="badge badge-status-<?= $user->active ? 'active' : 'inactive' ?>">
                            <?= $user->active ? 'Activo' : 'Inactivo' ?>
                        </span>
                    </td>
                    <td>
                        <span class="reactivos-count">
                            <?= count($user->reactivos ?? []) ?>
                        </span>
                    </td>
                    <td><?= h($user->created->format('d/m/Y H:i')) ?></td>
                    <td class="actions">
                        <?= $this->Html->link(__('Ver'), ['action' => 'view', $user->id], ['class' => 'button button-outline button-small']) ?>
                        <?= $this->Html->link(__('Editar'), ['action' => 'edit', $user->id], ['class' => 'button button-clear button-small']) ?>
                        <?php if ($user->id != $this->getRequest()->getAttribute('identity')->id): ?>
                            <?= $this->Form->postLink(__('Eliminar'), ['action' => 'delete', $user->id], ['confirm' => __('¿Estás seguro de que quieres eliminar a {0}?', $user->email), 'class' => 'button button-outline button-small delete-btn']) ?>
                        <?php endif; ?>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <div class="users-stats">
        <div class="stats-container">
            <div class="stat-card">
                <h4>Total de Usuarios</h4>
                <p class="stat-number"><?= count($users) ?></p>
            </div>
            <div class="stat-card">
                <h4>Administradores</h4>
                <p class="stat-number">
                    <?php
                    $admins = 0;
                    foreach ($users as $user) {
                        if ($user->role === 'administrador') $admins++;
                    }
                    echo $admins;
                    ?>
                </p>
            </div>
            <div class="stat-card">
                <h4>Usuarios Base</h4>
                <p class="stat-number">
                    <?php
                    $usuariosBase = 0;
                    foreach ($users as $user) {
                        if ($user->role === 'usuariobase') $usuariosBase++;
                    }
                    echo $usuariosBase;
                    ?>
                </p>
            </div>
            <div class="stat-card">
                <h4>Usuarios Activos</h4>
                <p class="stat-number">
                    <?php
                    $activos = 0;
                    foreach ($users as $user) {
                        if ($user->active) $activos++;
                    }
                    echo $activos;
                    ?>
                </p>
            </div>
        </div>
    </div>

    <div class="paginator">
        <ul class="pagination">
            <?= $this->Paginator->first('<< ' . __('Primera')) ?>
            <?= $this->Paginator->prev('< ' . __('Anterior')) ?>
            <?= $this->Paginator->numbers() ?>
            <?= $this->Paginator->next(__('Siguiente') . ' >') ?>
            <?= $this->Paginator->last(__('Última') . ' >>') ?>
        </ul>
        <p><?= $this->Paginator->counter(__('Página {{page}} de {{pages}}, mostrando {{current}} registro(s) de {{count}} total')) ?></p>
    </div>
</div>

<style>
.table-actions {
    margin-bottom: 1rem;
    overflow: hidden;
}

.float-right {
    float: right;
}

.table-responsive {
    overflow-x: auto;
    margin-bottom: 2rem;
}

.badge {
    padding: 0.3rem 0.6rem;
    border-radius: 3px;
    color: white;
    font-size: 0.8rem;
    font-weight: bold;
}

.badge-role-administrador {
    background-color: #dc3545;
}

.badge-role-usuariobase {
    background-color: #17a2b8;
}

.badge-status-active {
    background-color: #28a745;
}

.badge-status-inactive {
    background-color: #6c757d;
}

.reactivos-count {
    font-weight: bold;
    color: #495057;
    background-color: #e9ecef;
    padding: 0.3rem 0.6rem;
    border-radius: 3px;
}

.button-small {
    padding: 0.4rem 0.8rem;
    font-size: 0.8rem;
    margin: 0.1rem;
}

.delete-btn {
    border-color: #dc3545;
    color: #dc3545;
}

.delete-btn:hover {
    background-color: #dc3545;
    color: white;
}

.actions {
    min-width: 200px;
}

.users-stats {
    margin: 2rem 0;
}

.stats-container {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: 1rem;
}

.stat-card {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    padding: 1.5rem;
    border-radius: 8px;
    text-align: center;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
}

.stat-card h4 {
    margin: 0 0 1rem 0;
    font-size: 1rem;
    opacity: 0.9;
}

.stat-number {
    font-size: 2rem;
    font-weight: bold;
    margin: 0;
}

table {
    width: 100%;
    margin-bottom: 1rem;
}

table th,
table td {
    padding: 0.8rem;
    vertical-align: middle;
    border-bottom: 1px solid #dee2e6;
}

table th {
    background-color: #f8f9fa;
    font-weight: 600;
    border-bottom: 2px solid #dee2e6;
}

table tbody tr:hover {
    background-color: #f8f9fa;
}

.pagination {
    display: flex;
    justify-content: center;
    list-style: none;
    padding: 0;
    margin: 2rem 0;
}

.pagination li {
    margin: 0 0.25rem;
}

.pagination a {
    display: block;
    padding: 0.5rem 0.75rem;
    color: #007bff;
    text-decoration: none;
    background-color: #fff;
    border: 1px solid #dee2e6;
    border-radius: 0.25rem;
}

.pagination a:hover {
    color: #0056b3;
    background-color: #e9ecef;
    border-color: #dee2e6;
}

.pagination .current a {
    color: #fff;
    background-color: #007bff;
    border-color: #007bff;
}

.paginator p {
    text-align: center;
    color: #6c757d;
    margin-top: 1rem;
}

@media (max-width: 768px) {
    .table-responsive {
        font-size: 0.85rem;
    }

    .stats-container {
        grid-template-columns: repeat(2, 1fr);
    }

    .button-small {
        padding: 0.3rem 0.5rem;
        font-size: 0.7rem;
    }

    table th,
    table td {
        padding: 0.5rem;
    }
}

@media (max-width: 480px) {
    .stats-container {
        grid-template-columns: 1fr;
    }
}
</style>