<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Common extends Model
{
    //
    public function getTimeline($page,$pageSize){
        $skip=($page-1)*$pageSize;
        $sql='SELECT
	*
FROM
	(
		SELECT
			a.id,
			e.title AS question_title,
			e.`desc` AS question_description,
			e.user_id AS question_userid,
			e.username AS question_username,
			a.question_id,
			a.content AS answer_content,
			a.user_id AS answer_userid,
			b.username AS answer_username,
			a.created_at,
			a.updated_at
		FROM
			answers a
		LEFT JOIN users b ON a.user_id = b.id
		LEFT JOIN (
			SELECT
				c.id,
				c.`desc`,
				c.title,
				c.user_id,
				d.username
			FROM
				questions c
			LEFT JOIN users d ON c.user_id = d.id
		) e ON a.question_id = e.id
		UNION
			SELECT
				f.id,
				f.title AS question_title,
				f.`desc` AS question_description,
				f.user_id AS question_userid,
				g.username AS question_username,
				\'QUESTION\' AS question_id,
				\'QUESTION\' AS answer_content,
				\'QUESTION\' AS answer_userid,
				\'QUESTION\' AS answer_username,
				f.created_at,
				f.updated_at
			FROM
				questions f
			LEFT JOIN users g ON f.user_id = g.id
	) h
ORDER BY
	created_at DESC LIMIT ?,?';

        $answer=DB::select($sql,[$skip,$pageSize]);
        return $answer;
    }
}
