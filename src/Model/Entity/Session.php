<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Session Entity
 *
 * @property int $id
 * @property string $source_identifier
 * @property int $conference_id
 * @property int $track_id
 * @property \Cake\I18n\FrozenTime $start_at
 * @property int $duration_min
 * @property int $speaker_id
 * @property int $vote_group_id
 * @property int $number_of_votes
 * @property string $hash
 * @property string $title
 * @property string $description
 * @property bool $is_vote_target
 * @property bool $is_feedback_target
 * @property \Cake\I18n\FrozenTime $created
 * @property \Cake\I18n\FrozenTime $modified
 *
 * @property \App\Model\Entity\Conference $conference
 * @property \App\Model\Entity\Track $track
 * @property \App\Model\Entity\Speaker $speaker
 * @property \App\Model\Entity\VoteGroup $vote_group
 * @property \App\Model\Entity\SessionFeedback[] $session_feedbacks
 * @property \App\Model\Entity\Vote[] $votes
 */
class Session extends Entity
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
