<?php
use bfy\Model\Delivery;
/** @var Delivery $bl */
?>
<p><strong>Bordereau de livraison</strong></p>

<table>
    <tbody>
        <tr>
            <td><p><strong>Auteur(s):</strong></p></td>
            <td><p><?= $bl->getAuthor() ?></p></td>
        </tr>
    </tbody>
</table>

<h1>Checklist MEP</h1>
<ac:task-list>
<?php foreach ($bl->getTasks() as $task): ?>
    <ac:task>
        <ac:task-status>incomplete</ac:task-status>
        <ac:task-body><?= $task ?></ac:task-body>
    </ac:task>
<?php endforeach; ?>
</ac:task-list>

<h1>Objectifs</h1>
<p>Installation: <strong>preprod</strong></p>

<p>sf1 : <?= $bl->getVersions('sf1') ?></p>
<p>sf4-front: <?= $bl->getVersions('sf4front') ?></p>
<p>sf4-api: <?= $bl->getVersions('sf4api') ?></p>

<p>La livraison porte sur les tickets suivants:</p>
<h1>BL</h1>

<table data-layout="wide">
    <tbody>
        <tr>
            <th><p>Ticket</p></th>
            <th><p>Titre</p></th>
            <th><p>Cible</p></th>
            <th><p>Branche</p></th>
        </tr>
<?php foreach ($bl->getTickets() as $ticket): ?>
        <tr>
            <td><p><a href="<?= getenv('JIRA_WEB_URL').$ticket->getKey()?>"><?= $ticket->getKey() ?></a></p></td>
            <td><p><?= $ticket->getTitle() ?></p></td>
            <td><p><?= implode(', ', $ticket->getLabels()) ?></p></td>
            <td><p>feature-<?= $ticket->getKey() ?></p></td>
        </tr>
<?php endforeach; ?>
    </tbody>
</table>

<h1>Prerequis</h1>
<ac:task-list>
<?php foreach ($bl->getTickets() as $ticket): ?>
<?php foreach ($ticket->getDependsOn() as $key => $title): ?>
    <ac:task>
        <ac:task-status>incomplete</ac:task-status>
        <ac:task-body><a data-card-appearance="inline" href="<?= getenv('JIRA_WEB_URL').$key ?>"><?= "[$key] - $title" ?></a></ac:task-body>
    </ac:task>
<?php endforeach; ?>
<?php endforeach; ?>
</ac:task-list>
