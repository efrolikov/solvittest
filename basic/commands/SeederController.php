<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace app\commands;

use Yii;
use yii\console\Controller;
use yii\console\ExitCode;
use Faker\Factory;
use app\models\User;
use app\models\Album;
use app\models\Photo;

/**
 * This command echoes the first argument that you have entered.
 *
 * This command is provided as an example for you to learn how to create console commands.
 *
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class SeederController extends Controller
{
    /**
     * This command echoes what you have entered as the message.
     * @param string $message the message to be echoed.
     * @return int Exit code
     */
    public function actionIndex($pass)
    {
		if (!$pass) {
			echo "Need password\n";
			return ExitCode::OK;
		}
		if ($pass != Yii::$app->params['seederPass']) {
			echo "Password is wrong\n";
			return ExitCode::OK;
		}
		
		$faker = Factory::create();

		for ($i = 0; $i < 10; $i++) {
			$user = new User;
			$user->first_name = $faker->firstName;
			$user->last_name = $faker->lastName;
			if ($user->save()) {
				$user_id = $user->id;
				for ($j = 0; $j < 10; $j++) {
					$album = new Album;
					$album->user_id = $user_id;
					$album->title = $faker->text(20);
					if ($album->save()) {
						$album_id = $album->id;
						for ($k = 0; $k < 10; $k++) {
							$photo = new Photo;
							$photo->album_id = $album_id;
							$photo->title = $faker->text(20);
							$photo->save();
						}
					}
				}
			}
		}
		echo "Objects created!\n";
 
        return ExitCode::OK;
    }
}
