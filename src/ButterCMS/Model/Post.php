<?php

namespace ButterCMS\Model;

class Post extends Model
{
    protected $slug;
    protected $url;
    protected $published;
    protected $created;
    protected $status;
    protected $title;
    protected $body;
    protected $summary;
    protected $seo_title;
    protected $meta_description;
    protected $author;
    protected $categories;
    protected $tags;
    protected $featured_image;
<<<<<<< HEAD
=======
    protected $featured_image_alt;
>>>>>>> master

    public function __construct(array $data)
    {
        if (!empty($data['author'])) {
            $this->author = new Author($data['author']);
            unset($data['author']);
        }

        if (!empty($data['categories'])) {
            $this->categories = [];
            foreach ($data['categories'] as $categoryData) {
                $this->categories[] = new Category($categoryData);
            }
            unset($data['categories']);
        }

        if (!empty($data['tags'])) {
            $this->tags = [];
            foreach ($data['tags'] as $tagData) {
                $this->tags[] = new Tag($tagData);
            }
            unset($data['tags']);
        }

        parent::__construct($data);
    }

    public function isPublished()
    {
        return 'published' === $this->status;
    }

    public function resizeFeaturedImage($params = null)
    {
        $path = $this->featured_image;
        if ($params) {
            $t = explode('/', $path);
            $filename = $t[count($t) - 1];
            $path = str_ireplace('cdn.buttercms.com', 'fs.buttercms.com', $path);
            $commands = $this->resizeCommands($params);
            $path = str_ireplace($filename, $commands, $path);
            $path .= "/$filename";
        }
        return $path;
    }

    private function resizeCommands(array $params)
    {
        $cntr = 0;
        $response = 'resize=';
        foreach ($params as $key => $value) {
            if ($cntr > 0) {
                $response .= ',';
            }
            $response .= "$key:$value";
            $cntr++;
        }
        return $response;
    }
}
