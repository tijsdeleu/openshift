<?php

// src/AppBundle/Entity/Document.php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\HttpFoundation\File\UploadedFile;

/**
 * @ORM\Entity
 * @ORM\HasLifecycleCallbacks
 */
class Image
  {

  /**
   * @Assert\File(maxSize="6000000")
   */
  private $file;

  /**
   * Sets file.
   *
   * @param UploadedFile $file
   */
  public function setFile(UploadedFile $file = null)
  {
    $this->file = $file;
    if (isset($this->path))
    {
      // store the old name to delete after the update
      $this->temp = $this->path;
      $this->path = null;
    }
    else
    {
      $this->path = 'initial';
    }
  }

  /**
   * @ORM\PrePersist()
   * @ORM\PreUpdate()
   */
  public function preUpload()
  {
    if (null !== $this->getFile())
    {
      // do whatever you want to generate a unique name
      $filename = sha1(uniqid(mt_rand(), true));
      $this->path = $filename . '.' . $this->getFile()->guessExtension();
    }
  }

  /**
   * Get file.
   *
   * @return UploadedFile
   */
  public function getFile()
  {
    return $this->file;
  }

  /**
   * @ORM\Id
   * @ORM\Column(type="integer")
   * @ORM\GeneratedValue(strategy="AUTO")
   */
  public $id;

  /**
   * @ORM\Column(type="string", length=255)
   * @Assert\NotBlank
   */
  public $name;

  /**
   * @ORM\Column(type="string", length=255, nullable=true)
   */
  public $path;

  public function getAbsolutePath()
  {
    return null === $this->path ? null : $this->getUploadRootDir() . '/' . $this->path;
  }

  public function getWebPath()
  {
    return null === $this->path ? null : $this->getUploadDir() . '/' . $this->path;
  }

  protected function getUploadRootDir()
  {
    // the absolute directory path where uploaded
    // documents should be saved
    return __DIR__ . '/../../../web/' . $this->getUploadDir();
  }

  protected function getUploadDir()
  {
    // get rid of the __DIR__ so it doesn't screw up
    // when displaying uploaded doc/image in the view.
    return 'upload/images';
  }

  /**
   * @ORM\PostPersist()
   * @ORM\PostUpdate()
   */
  public function upload()
  {
    if (null === $this->getFile())
    {
      return;
    }
    $this->getFile()->move($this->getUploadRootDir(), $this->path);

    // check if we have an old image
    if (isset($this->temp))
    {
      // delete the old image
      unlink($this->getUploadRootDir() . '/' . $this->temp);
      // clear the temp image path
      $this->temp = null;
    }
    $this->file = null;
  }

  /**
   * @ORM\PostRemove()
   */
  public function removeUpload()
  {
    $file = $this->getAbsolutePath();
    if ($file)
    {
      unlink($file);
    }
  }

  }
