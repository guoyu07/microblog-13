<?php

namespace BlogBundle\Services;

use BlogBundle\Services\Markdown\BlogMarkdownFactory;
use Kisphp\Markdown;
use Symfony\Component\Finder\Finder;
use Symfony\Component\Finder\SplFileInfo;
use Symfony\Component\HttpFoundation\File\Exception\FileNotFoundException;

class ArticlesService
{
    /**
     * @var Markdown
     */
    protected $markdown;

    public function __construct()
    {
        $this->markdown = BlogMarkdownFactory::createMarkdown();
    }

    /**
     * @return array
     */
    public function getArticlesList()
    {
        $finder = new Finder();
        $finder->files()
            ->name('*.md')
            ->in($this->getMdFilesLocation())
        ;

        $articles = [];
        /** @var SplFileInfo $file */
        foreach ($finder as $file) {
            $articles[] = [
                'title' => $this->filterFileName($file),
                'registered' => $file->getMTime(),
                'content' => $this->getTruncatedContent($file),
            ];
        }

        return $articles;
    }

    /**
     * @param SplFileInfo $fileInfo
     *
     * @return string
     */
    protected function getTruncatedContent(SplFileInfo $fileInfo)
    {
        $content = file_get_contents($fileInfo->getRealPath());
        $content = $this->cleanupNewLines($content);
        $contentLines = explode("\n", $content);
        $firstLines = array_splice($contentLines, 0, 4);

        $truncatedContent = implode("\n", $firstLines);

        $cleanedContent = strip_tags($this->markdown->parse($truncatedContent));

        return nl2br($cleanedContent);
    }

    /**
     * @param $content
     *
     * @return mixed
     */
    protected function cleanupNewLines($content)
    {
        return preg_replace("/([\n]{2,})/", "\n", $content);
    }

    /**
     * @return string
     */
    protected function getMdFilesLocation()
    {
        return __DIR__ . '/../Resources/data/';
    }

    /**
     * @param SplFileInfo $fileInfo
     *
     * @return string
     */
    protected function filterFileName(SplFileInfo $fileInfo)
    {
        $text = $fileInfo->getFilename();
        $text = str_replace('.md', '', $text);

        return $text;
    }

    /**
     * @param $seoTitle
     *
     * @return array
     */
    public function getArticlesBySeoTitle($seoTitle)
    {
        $file = $this->getMdFilesLocation() . $seoTitle . '.md';

        if (!is_file($file)) {
            throw new FileNotFoundException($file);
        }

        $fileInfo = new \SplFileObject($file, 'r');

        return [
            'title' => $seoTitle,
            'registered' => $fileInfo->getMTime(),
            'content' => $this->markdown->parse(file_get_contents($fileInfo->getRealPath())),
        ];
    }
}
