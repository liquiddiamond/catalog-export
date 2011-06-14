<?php if (count($this->entries)): ?>

<?php foreach ($this->entries as $entry): ?>
<row>
<?php foreach ($entry['data'] as $field=>$data): ?>
<column id="<?php echo $field; ?>">
	<?php echo $data['value']; ?>
</column>
<?php endforeach; ?>
</row>
<?php endforeach; ?>

<?php else: ?>
<error>Invalid item reference for catalog.</error>
<?php endif; ?>