<?php foreach ($nodes as $node): ?>

        <h3><a href="/node/<?php echo $node['id'] ?>"><?php echo $node['title'] ?></a></h3>
        <div class="main">
                <?php echo $node['body_summary'] ?>
        </div>
        <p><a href="/node/<?php echo $node['id'] ?>">Читать</a></p>

<?php endforeach ?>
<?php echo $pagination ?>
