<?php
/**
 * @var \App\View\AppView $this
 * @var iterable<\App\Model\Entity\Reactivo> $reactivos
 */
$user = $this->getRequest()->getAttribute('identity');
?>

<div class="reactivos index content">
    <h3>
        <?= $user->role === 'administrador' ? 'Todos los Reactivos' : 'Mis Reactivos' ?>
    </h3>

    <div class="table-actions">
        <?= $this->Html->link(__('Crear Nuevo Reactivo'), ['action' => 'add'], ['class' => 'button float-right']) ?>
    </div>

    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th><?= $this->Paginator->sort('pregunta', 'Pregunta') ?></th>
                    <th><?= $this->Paginator->sort('area_especialidad', 'Área') ?></th>
                    <th><?= $this->Paginator->sort('subespecialidad', 'Subespecialidad') ?></th>
                    <th><?= $this->Paginator->sort('dificultad', 'Dificultad') ?></th>
                    <th><?= $this->Paginator->sort('respuesta_correcta', 'Resp. Correcta') ?></th>
                    <?php if ($user->role === 'administrador'): ?>
                        <th><?= $this->Paginator->sort('Users.email', 'Creado por') ?></th>
                    <?php endif; ?>
                    <th><?= $this->Paginator->sort('created', 'Fecha Creación') ?></th>
                    <th class="actions"><?= __('Acciones') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($reactivos as $reactivo): ?>
                <tr>
                    <td class="pregunta-cell">
                        <?= $this->Text->truncate(h($reactivo->pregunta), 100) ?>
                    </td>
                    <td><?= h($reactivo->area_especialidad) ?></td>
                    <td><?= h($reactivo->subespecialidad) ?></td>
                    <td>
                        <span class="badge badge-dificultad-<?= $reactivo->dificultad ?>">
                            <?= $reactivo->dificultad ?>
                        </span>
                    </td>
                    <td>
                        <span class="respuesta-correcta">
                            <?= h($reactivo->respuesta_correcta) ?>
                        </span>
                    </td>
                    <?php if ($user->role === 'administrador'): ?>
                        <td><?= h($reactivo->user->email ?? 'N/A') ?></td>
                    <?php endif; ?>
                    <td><?= h($reactivo->created->format('d/m/Y H:i')) ?></td>
                    <td class="actions">
                        <?= $this->Html->link(__('Ver'), ['action' => 'view', $reactivo->id], ['class' => 'button button-outline button-small']) ?>
                        <?php if ($user->role === 'administrador' || $reactivo->user_id == $user->id): ?>
                            <?= $this->Html->link(__('Editar'), ['action' => 'edit', $reactivo->id], ['class' => 'button button-clear button-small']) ?>
                            <?= $this->Form->postLink(__('Eliminar'), ['action' => 'delete', $reactivo->id], ['confirm' => __('¿Estás seguro de que quieres eliminar este reactivo?'), 'class' => 'button button-outline button-small delete-btn']) ?>
                        <?php endif; ?>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <?php if (empty($reactivos->toArray())): ?>
        <div class="empty-state">
            <h4>No hay reactivos disponibles</h4>
            <p>
                <?php if ($user->role === 'administrador'): ?>
                    No se han creado reactivos en el sistema aún.
                <?php else: ?>
                    No has creado ningún reactivo aún.
                <?php endif; ?>
            </p>
            <?= $this->Html->link('Crear el primer reactivo', ['action' => 'add'], ['class' => 'button']) ?>
        </div>
    <?php endif; ?>

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
}

.pregunta-cell {
    max-width: 300px;
    word-wrap: break-word;
}

.badge {
    padding: 0.3rem 0.6rem;
    border-radius: 3px;
    color: white;
    font-size: 0.8rem;
    font-weight: bold;
}

.badge-dificultad-1 { background-color: #28a745; }
.badge-dificultad-2 { background-color: #17a2b8; }
.badge-dificultad-3 { background-color: #ffc107; color: #212529; }
.badge-dificultad-4 { background-color: #fd7e14; }
.badge-dificultad-5 { background-color: #dc3545; }

.respuesta-correcta {
    font-weight: bold;
    color: #28a745;
    background: #d4edda;
    padding: 0.2rem 0.5rem;
    border-radius: 3px;
}

.button-small {
    padding: 0.5rem 1rem;
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

.empty-state {
    text-align: center;
    padding: 3rem;
    background-color: #f8f9fa;
    border-radius: 5px;
    margin: 2rem 0;
}

.empty-state h4 {
    color: #6c757d;
    margin-bottom: 1rem;
}

.empty-state p {
    color: #6c757d;
    margin-bottom: 1.5rem;
}

table {
    width: 100%;
    margin-bottom: 1rem;
}

table th,
table td {
    padding: 0.8rem;
    vertical-align: top;
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
        font-size: 0.9rem;
    }

    .pregunta-cell {
        max-width: 200px;
    }

    .button-small {
        padding: 0.3rem 0.6rem;
        font-size: 0.7rem;
    }

    table th,
    table td {
        padding: 0.5rem;
    }
}
</style>