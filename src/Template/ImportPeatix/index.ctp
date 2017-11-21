<?php $this->extend('../Layout/TwitterBootstrap/dashboard'); ?>

<p class="bg-info">
    Peatux のCSVをインポートします。
</p>

<?= $this->Form->create($importPeatix, ["type" => "file"]); ?>

<?= $this->Form->control('conference_id', ['options' => $conferences]); ?>


<?= $this->Form->label('CSVファイル'); ?>

<div id="dnd-zone">
    <p>ここにファイルをドロップ / 複数可</p>
    <?= $this->Form->control('files[]', ['type' => 'file', 'id' => 'file-field', 'label' => false, 'required', 'multiple']); ?>
</div>
<?= $this->Form->submit(__('Submit'), ['class' => ['btn', 'btn-primary']]); ?>

<?= $this->Form->end(); ?>

<?= $this->start('css'); ?>
<style>
    p.bg-info { padding:15px; margin:20px 0; }
    #dnd-zone { margin:10px 0 20px 0; background-color:#f0f0f0; padding:30px; width:300px; }

    .dragover {
        background-color:#f48fb1 !important;
    }
</style>
<?= $this->end(); ?>

<?= $this->start('script'); ?>
<script>
    $(function(){
        var dndZone = $('#dnd-zone');
        var fileField = $('#file-field');

        dndZone.on('dragover', function(e){
            e.preventDefault();
            dndZone.addClass('dragover');
        });
        dndZone.on('dragleave', function(e){
            e.preventDefault();
            dndZone.removeClass('dragover');
        });

        dndZone.on('drop', function(e){
            e.preventDefault();
            dndZone.removeClass('dragover');
            fileField.prop('files', e.originalEvent.dataTransfer.files);
        });
    });
</script>
<?= $this->end(); ?>

