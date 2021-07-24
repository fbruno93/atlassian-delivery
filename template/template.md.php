<?php
use bfy\Model\Delivery;
/** @var Delivery $bl */
?>
# Bordereau de livraison
Auteur(s): <?= $bl->getAuthor() ?>


# Checklist MEP
<?php foreach ($bl->getTasks() as $task): ?>
- [ ] <?= $task ?>

<?php endforeach; ?>

# Objectifs
Installation: *preprod*

sf1 : <?= $bl->getVersions('sf1') ?>

sf4-front: <?= $bl->getVersions('sf4front') ?>

sf4-api: <?= $bl->getVersions('sf4api') ?>


# BL
| Ticket | Titre | Cible | Branche |
|--------|-------|-------|---------|
<?php foreach ($bl->getTickets() as $ticket): ?>
<?= $ticket->getKey() ?> | <?= $ticket->getTitle() ?> | <?= implode(', ', $ticket->getLabels()) ?> | feature-<?= $ticket->getKey() ?>

<?php endforeach; ?>

# Prérequis
<?php foreach ($bl->getTickets() as $ticket): ?>
<?php foreach ($ticket->getDependsOn() as $key => $title): ?>
- [ ] <?= "[$key] - $title" ?>

<?php endforeach; ?>
<?php endforeach; ?>
