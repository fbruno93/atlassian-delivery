<?php

namespace bfy\Model;

use bfy\Atlassian\Model\IssueGetResponse;

/**
 * Class Delivery
 * representative class of a software delivery
 */
abstract class Delivery
{
    private string $title;
    private string $author;
    /** @var IssueGetResponse[]  */
    private array $tickets;
    private array $versions = [
        'sf1' => null,
        'sf4api' => null,
        'sf4front' => null,
    ];

    private array $tasks = [
        "Modification de structure ES ?",
        "Modification de structure BDD ?",
        "Modification de variable d'environnement ?",
        "Modification transifex ?",
        "Modification impactant Quebecor ? (API search, modif d'indexAlgolia,...) Prévenir Julien Saget",
        "Ne pas faire de MEP BO ou XB entre 13h et 14h pour cause de renouvellement US",
    ];

    private function __construct()
    {
        $this->title = 'BL '.date('Y-m-d H:i:s');
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function getAuthor(): string
    {
        return $this->author;
    }

    public function setAuthor($author): self
    {
        $this->author = $author;

        return $this;
    }

    /**
     * @return IssueGetResponse[]
     */
    public function getTickets(): array
    {
        return $this->tickets;
    }

    /**
     * @param IssueGetResponse[] $tickets
     * @return $this
     */
    public function setTickets(array $tickets): self
    {
        $this->tickets = $tickets;

        return $this;
    }

    public function getVersions(string $version): string
    {
        return $this->versions[$version] ?? 'n/a';
    }

    public function setVersions(array $versions): self
    {
        $this->versions = $versions;

        return $this;
    }

    public function getNotes(): string
    {
        $notes = '';
        foreach ($this->versions as $app => $version) {
            if (!$version) {
                continue;
            }

            $notes.= "$app: $version ; ";
        }

        return mb_substr($notes, 0, -3);
    }

    public function getTasks(): array
    {
        return $this->tasks;
    }

    public static function buildDelivery($debug = false): Delivery
    {
        return $debug ? new DeliveryMD() : new DeliveryXML();
    }
}
