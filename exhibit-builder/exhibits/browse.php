<?php
$title = __('Chapters');
echo head(array('title' => $title, 'bodyclass' => 'exhibits browse'));
?>
<h1><?php echo $title; ?></h1>
<?php if (count($exhibits) > 0): ?>

<?php echo pagination_links(); ?>

<?php $exhibitCount = 0; ?>
<?php foreach (loop('exhibit') as $exhibit): ?>
    <?php $exhibitCount++; ?>
    <div class="exhibit <?php if ($exhibitCount%2==1) echo ' even'; else echo ' odd'; ?>">
        <h2><?php echo link_to_exhibit(); ?></h2>
    </div>
<?php endforeach; ?>

<?php echo pagination_links(); ?>

<?php else: ?>

<p><?php echo __('There are no exhibits available yet.'); ?></p>

<?php endif; ?>

<?php echo foot(); ?>
