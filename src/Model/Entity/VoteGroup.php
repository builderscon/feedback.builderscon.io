<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * VoteGroup Entity
 *
 * @property int $id
 * @property int $conference_id
 * @property string $name
 * @property string $slug
 * @property int $voting_cards
 * @property \Cake\I18n\FrozenTime $voting_close_at
 * @property \Cake\I18n\FrozenTime $created
 * @property \Cake\I18n\FrozenTime $modified
 *
 * @property \App\Model\Entity\Conference $conference
 * @property \App\Model\Entity\Session[] $sessions
 */
class VoteGroup extends Entity
{

    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * Note that when '*' is set to true, this allows all unspecified fields to
     * be mass assigned. For security purposes, it is advised to set '*' to false
     * (or remove it), and explicitly make individual fields accessible as needed.
     *
     * @var array
     */
    protected $_accessible = [
        '*' => true,
        'id' => false
    ];
}
