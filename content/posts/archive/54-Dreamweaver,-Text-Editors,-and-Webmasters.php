<?php
use PhlyBlog\EntryEntity;

$entry = new EntryEntity();

$entry->setId('54-Dreamweaver,-Text-Editors,-and-Webmasters');
$entry->setTitle('Dreamweaver, Text Editors, and Webmasters');
$entry->setAuthor('matthew');
$entry->setDraft(false);
$entry->setPublic(true);
$entry->setCreated(1105240938);
$entry->setUpdated(1105240945);
$entry->setTimezone('America/New_York');
$entry->setMetadata(array (
));
$entry->setTags(array (
  0 => 'programming',
  1 => 'personal',
));

$body =<<<'EOT'
<p>
    I picked up on <a href="http://osdir.com/slash3344.html">this article</a> on
    Friday, glanced through it and moved on, but noticed this evening it had
    been <a href="http://developers.slashdot.org/article.pl?sid=05/01/08/2129250&tid=185">slashdotted</a>
    -- at which point I realized the author is the current <a href="http://www.perl.com/pub/a/2001/06/05/cgi.html">CGI::Application</a>
    maintainer, so I looked again.  </p> <p> At my first glance through it, it
    appeared the author was looking for a nice, easy-to-use pre-processor script
    for generating a site out of templates and content files. To that end, he,
    in the end, recommended <em>ttree</em>, part of the <a href="http://search.cpan.org/~abw/Template-Toolkit-2.14/">Template
        Toolkit</a> distribution.
</p>
<p>
    However, the real gist of the article -- something that should probably have
    been summarized at the end -- is that the author was looking for an free and
    OSS replacement for DreamWeaver's Templates functionality. This
    functionality allows a developer to create a template with placeholders for
    content, lock it, and then create pages that have the bits and pieces of
    content. Finally, the developer compiles the site -- creating final HTML
    pages out of the content merged with the templates.
</p>
<p>
    Now, I can see something like this being useful. I've used <a href="http://search.cpan.org/author/JMASON/HTML-WebMake-2.2/webmake.raw">webmake</a>
    for a couple of projects, and, obviously, utilize PHP in many places as a
    templating language. However, several comments on Slashdot also gave some
    pause. The tone of these comments was to the effect of, "real developers
    shouldn't use DW; they should understand HTML and code it directly." Part of
    me felt this was elitist -- the web is such an egalitarian medium that there
    should be few barriers to entry. However, the <em>webmaster</em> in me --
    the professional who gets paid each pay period and makes a living off the
    web -- also agreed with this substantially.
</p>
<p>
    I've worked -- both professionally and as a freelancer -- with individuals
    who use and rely on DW. The problem I see with the tool and others of its
    breed is precisely their empowerment of people. Let me explain.
</p>
<p>
    I really do feel anybody should be able to have a presence on the 'net.
    However, HTML is a fragile language: trivial errors can cause tremendous
    changes in how a page is rendered -- and even crash browsers on occasion.
    The problem I see is that DW and other GUI webpage applications create, from
    my viewpoint, garbage HTML. I cannot tell you how many pages generated by
    these applications that I've had to clean up and reformat. They spuriously
    add tags, often around empty content, that are simply unnecessary.
</p>
<p>
    The problem is compounded when individuals have neither time nor inclination
    to learn HTML, but continue using the tool to create pages. They get a false
    sense of accomplishment -- that can be quickly followed by a very real sense
    of incompetence when the page inexplicably breaks due to an edit they've
    made -- especially when the content is part of a larger framework that
    includes other files. Of course, as a web professional, I get paid to fix
    such mistakes. But I feel that this does everybody a disservice -- the
    individual/company has basically paid twice for the presentation of content
    -- once to the person generating it, a second time to me to fix the errors.
</p>
<p>
    This is a big part of the reason why I've been leaning more and more heavily
    on database-driven web applications. Content then goes into the database,
    and contains minimal -- if any -- markup. It is then injected into
    templates, which go through a formal review process, as well as through the
    <a href="http://www.w3c.org">W3C</a> validators, to prevent display
    problems. This puts everybody in a position of strength: the editor
    generating content, the designer creating the look-and-feel, and the
    programmer developing the methods for mapping content with the templates.
</p>
<p>
    There's still a part of me that struggles with what I perceive as an elitist
    position. However, there's another part of me that has struggled heavily
    with the multitasking demands made on all web professionals -- we're
    expected to be editors, graphic designers, programmers, and more. In most
    cases, we're lucky if we're strong in one or two such areas, much less
    passionate about staying abreast of the changing face of our medium.
</p>
EOT;
$entry->setBody($body);

$extended=<<<'EOT'

EOT;
$entry->setExtended($extended);

return $entry;