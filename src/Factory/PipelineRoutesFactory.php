<?php

namespace Mwop\Factory;

use Interop\Container\ContainerInterface;
use Mwop\Auth;
use Mwop\Blog;
use Mwop\ComicsPage;
use Mwop\Contact;
use Mwop\ContentSecurityPolicy;
use Mwop\ErrorHandler;
use Mwop\HomePage;
use Mwop\NotFound;
use Mwop\OfflinePage;
use Mwop\Redirects;
use Mwop\ResumePage;
use Mwop\XClacksOverhead;
use Mwop\XPoweredBy;
use Zend\Expressive\Application;
use Zend\Expressive\Helper;
use Zend\Stratigility\Middleware\OriginalMessages;

class PipelineRoutesFactory
{
    public function __invoke(ContainerInterface $container, $name, callable $callback) : Application
    {
        $app = $callback();
        $this->injectPipeline($app);
        $this->injectRoutes($app);
        return $app;
    }

    /**
     * @param Application $app
     * @return void
     */
    private function injectPipeline(Application $app)
    {
        $app->pipe(OriginalMessages::class);
        $app->pipe(ErrorHandler::class);
        $app->pipe(ContentSecurityPolicy::class);
        $app->pipe(XClacksOverhead::class);
        $app->pipe(XPoweredBy::class);
        $app->pipe(Redirects::class);
        $app->pipe('/auth', Auth\Middleware::class);
        $app->pipeRoutingMiddleware();
        $app->pipe(Helper\UrlHelperMiddleware::class);
        $app->pipeDispatchMiddleware();
        $app->pipe(NotFound::class);
    }

    /**
     * @param Application $app
     * @return void
     */
    private function injectRoutes(Application $app)
    {
        // General pages
        $app->get('/', HomePage::class, 'home');
        $app->get('/comics', ComicsPage::class, 'comics');
        $app->get('/offline', OfflinePage::class, 'offline');
        $app->get('/resume', ResumePage::class, 'resume');

        // Blog
        $app->get('/blog[/]', Blog\ListPostsMiddleware::class, 'blog');
        $app->get('/blog/{id:[^/]+}.html', Blog\DisplayPostMiddleware::class, 'blog.post');
        $app->get('/blog/tag/{tag:php}.xml', Blog\FeedMiddleware::class, 'blog.feed.php');
        $app->get('/blog/{tag:php}.xml', Blog\FeedMiddleware::class, 'blog.feed.php.also');
        $app->get('/blog/tag/{tag:[^/]+}/{type:atom|rss}.xml', Blog\FeedMiddleware::class, 'blog.tag.feed');
        $app->get('/blog/tag/{tag:[^/]+}', Blog\ListPostsMiddleware::class, 'blog.tag');
        $app->get('/blog/{type:atom|rss}.xml', Blog\FeedMiddleware::class, 'blog.feed');

        // Contact form
        $app->get('/contact[/]', Contact\LandingPage::class, 'contact');
        $app->post('/contact/process', Contact\Process::class, 'contact.process');
        $app->get('/contact/thank-you', Contact\ThankYouPage::class, 'contact.thank-your');
    }
}
