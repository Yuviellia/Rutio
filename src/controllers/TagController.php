<?php
require_once 'src/controllers/AppController.php';
require_once __DIR__ . '/../repository/TagRepository.php';

class TagController extends AppController {
    private $tagRepository;

    public function __construct() {
        parent::__construct();
        $this->tagRepository = new TagRepository();
    }

    public function dashboard() {

        $tags = $this->tagRepository->getTags();
        $marks = [];
        foreach ($tags as $tag) {
            $marks[$tag['id']] = $this->tagRepository->getMarked($tag['id']);
        }

        try {
            $this->render('dashboard', ['startDate' => new DateTime($_GET['startDate']), 'tags' => $tags, 'marks' => $marks]);
        } catch (Exception $e) {
            $this->render('dashboard', ['tags' => $tags, 'marks' => $marks]);
        }
    }

    public function addG() {
        if($this->isPost()){
            $this->tagRepository->addTag($_POST['tag']);

            $startDate = $_POST['startDate'];
            header("Location: /dashboard?startDate=$startDate");
        } else header("Location: /dashboard");
    }

    public function deleteG() {
        if($this->isPost()){
            $this->tagRepository->deleteTag($_POST['tag']);

            $startDate = $_POST['startDate'];
            header("Location: /dashboard?startDate=$startDate");
        } else header("Location: /dashboard");
    }

    public function mark() {
        if($this->isPost()){
            if(isset($_POST['marked'])) $this->tagRepository->mark($_POST['id'], $_POST['date']);
            else $this->tagRepository->unmark($_POST['id'], $_POST['date']);


            $startDate = $_POST['startDate'];
            header("Location: /dashboard?startDate=$startDate");
        } else header("Location: /dashboard");
    }

}