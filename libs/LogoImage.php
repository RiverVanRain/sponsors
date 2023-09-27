<?php

namespace humhub\modules\sponsors\libs;

use Yii;
use yii\base\ErrorException;
use yii\base\Exception;
use yii\imagine\Image;
use yii\web\UploadedFile;
use yii\helpers\Url;
use yii\helpers\FileHelper;

/**
 * LogoImage
 */
class LogoImage
{
    /**
     * Sets a new icon for the installation.
     * @param UploadedFile|null $file
     */
    public static function set(UploadedFile $file = null, $name)
    {
        if (!$name) {
			return null;
		}
		
		static::deleteFiles($name);
		
		if ($file !== null) {
            try {
                FileHelper::createDirectory(Yii::getAlias('@webroot/uploads/sponsors/'));
            } catch (Exception $e) {
            }
            Image::getImagine()->open($file->tempName)->save(Yii::getAlias('@webroot/uploads/sponsors/' . $name . '.png'));
			static::getUrl($name);
        }
    }

    /**
     * Returns the URL of the logo image in desired maximum sizes (width and/or height)
     *
     * @param int|null $maxWidth the maximum width in pixel
     * @param int|null $maxHeight the maximum width in pixel
     * @param bool $autoResize automatically resize to given size if not available yet
     * @return string|null
     */
    public static function getUrl($name = null, $maxWidth = null, $maxHeight = null, $autoResize = true)
    {
        if (!$name) {
			return null;
		}
		
		if ($maxWidth === null) {
            // Will change in future!
            $maxWidth = 50;
        }

        if ($maxHeight === null) {
            // Will change in future!
            $maxHeight = 50;
        }

        $file = self::getFile($name, $maxWidth, $maxHeight);
        if (file_exists($file) && filemtime(static::getOriginalFile($name)) < filemtime($file)) {
			// Workaround for absolute urls in console applications (Cron)
            $base = '';
            if (Yii::$app->request->isConsoleRequest) {
                $base = Url::base(true);
            }
            return $base . Yii::getAlias(Yii::$app->assetManager->baseUrl) . '/sponsors/' . static::buildFileName($name, $maxWidth, $maxHeight) . '?v=' . filemtime($file);
        } else if (static::hasImage($name) && $autoResize) {
            try {
                FileHelper::createDirectory(Yii::getAlias(Yii::$app->assetManager->basePath . DIRECTORY_SEPARATOR . 'sponsors'));
            } catch (Exception $e) {
            }

            $image = Image::getImagine()->open(static::getOriginalFile($name));
            if ($image->getSize()->getHeight() > $maxHeight) {
                $image->resize($image->getSize()->heighten($maxHeight));
            }
            if ($image->getSize()->getWidth() > $maxWidth) {
                $image->resize($image->getSize()->widen($maxWidth));
            }
            $image->save($file);

            return static::getUrl($name, $maxWidth, $maxHeight, false);
        }

        return null;
    }

    /**
     * Indicates there is a logo image
     *
     * @return Boolean is there a logo image
     */
    public static function hasImage($name)
    {
        if (!$name) {
			return null;
		}
		
		return file_exists(static::getOriginalFile($name));
    }

    public static function getFile($name, $maxWidth, $maxHeight)
    {
        if (!$name) {
			return null;
		}
		
		return Yii::getAlias(Yii::$app->assetManager->basePath . DIRECTORY_SEPARATOR . 'sponsors' . DIRECTORY_SEPARATOR . static::buildFileName($name, $maxWidth, $maxHeight));
    }

    public static function buildFileName($name, $maxWidth, $maxHeight)
    {
        if (!$name) {
			return null;
		}
		
		$fileName = $name . '_' . $maxWidth . 'x' . $maxHeight . '.png';
        return $fileName;
    }

    public static function getOriginalFile($name)
    {
        if (!$name) {
			return null;
		}
		
		return Yii::getAlias('@webroot/uploads/sponsors/' . $name . '.png');
    }

    public static function deleteFiles($name)
    {
        if (!$name) {
			return null;
		}
		
		try {
            FileHelper::unlink(static::getOriginalFile($name));
        } catch (ErrorException $e) {
            Yii::error($e, 'admin');
        }
    }

}
