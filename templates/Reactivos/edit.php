<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Reactivo $reactivo
 * @var array $especialidades
 */
$isEdit = !$reactivo->isNew();
$title = $isEdit ? 'Editar Reactivo' : 'Crear Nuevo Reactivo';
?>

<div class="reactivos form">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Acciones') ?></h4>
            <?php if ($isEdit): ?>
                <?= $this->Form->postLink(
                    __('Eliminar'),
                    ['action' => 'delete', $reactivo->id],
                    ['confirm' => __('¿Estás seguro de que quieres eliminar este reactivo?'), 'class' => 'side-nav-item button button-outline']
                ) ?>
            <?php endif; ?>
            <?= $this->Html->link(__('Listar Reactivos'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>

    <div class="column column-80">
        <div class="reactivos form content">
            <h3><?= $title ?></h3>

            <?= $this->Form->create($reactivo) ?>
            <fieldset>
                <legend><?= __('Información del Reactivo') ?></legend>

                <?= $this->Form->control('pregunta', [
                    'type' => 'textarea',
                    'label' => 'Pregunta',
                    'rows' => 4,
                    'placeholder' => 'Escribe aquí la pregunta del examen...',
                    'required' => true
                ]) ?>

                <div class="row">
                    <div class="column">
                        <?= $this->Form->control('respuesta_a', [
                            'label' => 'Respuesta A',
                            'placeholder' => 'Primera opción de respuesta',
                            'required' => true
                        ]) ?>
                    </div>
                    <div class="column">
                        <?= $this->Form->control('respuesta_b', [
                            'label' => 'Respuesta B',
                            'placeholder' => 'Segunda opción de respuesta',
                            'required' => true
                        ]) ?>
                    </div>
                </div>

                <div class="row">
                    <div class="column">
                        <?= $this->Form->control('respuesta_c', [
                            'label' => 'Respuesta C',
                            'placeholder' => 'Tercera opción de respuesta',
                            'required' => true
                        ]) ?>
                    </div>
                    <div class="column">
                        <?= $this->Form->control('respuesta_correcta', [
                            'type' => 'select',
                            'label' => 'Respuesta Correcta',
                            'options' => [
                                'A' => 'A',
                                'B' => 'B',
                                'C' => 'C'
                            ],
                            'empty' => 'Selecciona la respuesta correcta',
                            'required' => true
                        ]) ?>
                    </div>
                </div>

                <?= $this->Form->control('retroalimentacion', [
                    'type' => 'textarea',
                    'label' => 'Retroalimentación',
                    'rows' => 3,
                    'placeholder' => 'Explicación de la respuesta correcta (opcional)...'
                ]) ?>

                <div class="row">
                    <div class="column">
                        <?= $this->Form->control('dificultad', [
                            'type' => 'select',
                            'label' => 'Nivel de Dificultad',
                            'options' => [
                                1 => '1 - Muy Fácil',
                                2 => '2 - Fácil',
                                3 => '3 - Medio',
                                4 => '4 - Difícil',
                                5 => '5 - Muy Difícil'
                            ],
                            'empty' => 'Selecciona la dificultad',
                            'required' => true
                        ]) ?>
                    </div>
                </div>

                <div class="row">
                    <div class="column">
                        <?= $this->Form->control('area_especialidad', [
                            'type' => 'select',
                            'label' => 'Área de Especialidad',
                            'options' => array_keys($especialidades),
                            'empty' => 'Selecciona el área de especialidad',
                            'id' => 'area-especialidad',
                            'required' => true
                        ]) ?>
                    </div>
                    <div class="column">
                        <?= $this->Form->control('subespecialidad', [
                            'type' => 'select',
                            'label' => 'Subespecialidad',
                            'options' => [],
                            'empty' => 'Selecciona primero el área',
                            'id' => 'subespecialidad',
                            'required' => true
                        ]) ?>
                    </div>
                </div>
            </fieldset>

            <div class="form-actions">
                <?= $this->Form->button(__($isEdit ? 'Actualizar Reactivo' : 'Crear Reactivo'), [
                    'class' => 'button button-primary'
                ]) ?>
                <?= $this->Html->link(__('Cancelar'), ['action' => 'index'], [
                    'class' => 'button button-outline'
                ]) ?>
            </div>

            <?= $this->Form->end() ?>
        </div>
    </div>
</div>

<script>
// JavaScript para manejar las subespecialidades dinámicamente
document.addEventListener('DOMContentLoaded', function() {
    const especialidades = <?= json_encode($especialidades) ?>;
    const areaSelect = document.getElementById('area-especialidad');
    const subSelect = document.getElementById('subespecialidad');

    // Valores actuales (para edición)
    const currentArea = '<?= $reactivo->area_especialidad ?? '' ?>';
    const currentSub = '<?= $reactivo->subespecialidad ?? '' ?>';

    function updateSubespecialidades() {
        const selectedArea = areaSelect.value;

        // Limpiar opciones
        subSelect.innerHTML = '<option value="">Selecciona la subespecialidad</option>';

        if (selectedArea) {
            // Convertir el índice numérico al nombre de la especialidad
            const areaNames = Object.keys(especialidades);
            const selectedAreaName = areaNames[parseInt(selectedArea)];

            if (selectedAreaName && especialidades[selectedAreaName]) {
                especialidades[selectedAreaName].forEach(function(sub) {
                    const option = document.createElement('option');
                    option.value = sub;
                    option.textContent = sub;

                    // Mantener selección actual en caso de edición
                    if (sub === currentSub) {
                        option.selected = true;
                    }

                    subSelect.appendChild(option);
                });
            }
        }
    }

    // Evento de cambio
    areaSelect.addEventListener('change', updateSubespecialidades);

    // Cargar inicial (para edición)
    if (currentArea) {
        updateSubespecialidades();
    }
});
</script>

<style>
.reactivos.form {
    display: flex;
    gap: 2rem;
}

.side-nav {
    background: #f8f9fa;
    padding: 1.5rem;
    border-radius: 5px;
    height: fit-content;
}

.side-nav .heading {
    margin-top: 0;
    color: #2c3e50;
}

.side-nav-item {
    display: block;
    padding: 0.5rem 0;
    color: #3498db;
    text-decoration: none;
    border-bottom: 1px solid #e9ecef;
}

.side-nav-item:hover {
    color: #2980b9;
}

.form-actions {
    margin-top: 2rem;
    padding-top: 1rem;
    border-top: 1px solid #e9ecef;
}

.form-actions .button {
    margin-right: 1rem;
}

fieldset {
    border: 1px solid #e9ecef;
    border-radius: 5px;
    padding: 1.5rem;
    margin-bottom: 1rem;
}

legend {
    font-weight: bold;
    color: #2c3e50;
    padding: 0 1rem;
}

.row {
    display: flex;
    gap: 1rem;
    margin-bottom: 1rem;
}

.column {
    flex: 1;
}

@media (max-width: 768px) {
    .reactivos.form {
        flex-direction: column;
    }

    .row {
        flex-direction: column;
        gap: 0;
    }
}
</style>