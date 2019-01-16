<?php
/**
 * @license http://opensource.org/licenses/BSD-2-Clause BSD-2-Clause
 * @copyright Copyright (c) Matthew Weier O'Phinney
 */

namespace Mwop\Blog;

use Phly\EventDispatcher\ListenerProvider\AttachableListenerProvider;

class ConfigProvider
{
    public function __invoke() : array
    {
        return [
            'blog'         => $this->getConfig(),
            'dependencies' => $this->getDependencies(),
            'blog' => [
            ],
        ];
    }

    public function getConfig() : array
    {
        return [
            'db'     => null,
            'cache'  => [
                'enabled' => false,
            ],
            'disqus' => [
                'developer' => 0,
                'key'       => null,
            ],
        ];
    }

    public function getDependencies() : array
    {
        return [
            'factories' => [
                BlogCachePool::class                            => BlogCachePoolFactory::class,
                Console\ClearCache::class                       => Console\ClearCacheFactory::class,
                Console\FeedGenerator::class                    => Console\FeedGeneratorFactory::class,
                Console\TagCloud::class                         => Console\TagCloudFactory::class,
                Handler\DisplayPostHandler::class               => Handler\DisplayPostHandlerFactory::class,
                Handler\FeedHandler::class                      => Handler\FeedHandlerFactory::class,
                Handler\ListPostsHandler::class                 => Handler\ListPostsHandlerFactory::class,
                Handler\SearchHandler::class                    => Handler\SearchHandlerFactory::class,
                Mapper\MapperInterface::class                   => Mapper\MapperFactory::class,
                Listener\CacheBlogPostListener::class           => Listener\CacheBlogPostListenerFactory::class,
                Listener\FetchBlogPostFromMapperListener::class => Listener\FetchBlogPostFromMapperListenerFactory::class,
                Listener\FetchBlogPostFromCacheListener::class  => Listener\FetchBlogPostFromCacheListenerFactory::class,
            ],
            'invokables' => [
                Console\GenerateSearchData::class => Console\GenerateSearchData::class,
                Console\SeedBlogDatabase::class   => Console\SeedBlogDatabase::class,
            ],
            'delegators' => [
                AttachableListenerProvider::class => [
                    Listener\BlogPostEventListenersDelegator::class,
                ],
            ],
        ];
    }
}