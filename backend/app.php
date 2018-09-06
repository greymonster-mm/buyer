<?php

require './vendor/autoload.php';

use Yaf\Model\Entities\BlogArticle;
use Yaf\Model\Repository\BlogContentRepository;
$test = $em->getRepository('Yaf\Model\Entities\BlogArticle');
