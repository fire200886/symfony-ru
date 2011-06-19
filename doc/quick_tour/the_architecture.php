<div class="column_02">

  <div class="box_title">
    <h1 class="title_01">Архитектура</h1>
  </div>
  
  <div class="box_quick_tour">
    <ul class="quick_tour_list clear_fix">
      <li><a href="<?php l('doc/quick_tour/the_big_picture')?>">Общая картина</a></li> > 
      <li><a href="<?php l('doc/quick_tour/the_view')?>">Вид</a></li> > 
      <li><a href="<?php l('doc/quick_tour/the_controller')?>">Контроллер</a></li> > 
      <li>Архитектура</li>
    </ul>
  </div>


  <div class="box_article doc_page">

    
    
    <div class="section" id="the-architecture">
      <h1>Архитктура<a class="headerlink" href="#the-architecture" title="Permalink to this headline">¶</a></h1>
      <p>Вы мой герой! Кто бы мог подумать, что вы все еще будете здесь после первых трех частей? Ваши усилия скоро будут вознаграждены. В первых частях мы глубоко не рассматривали архитектуру фреймворка. Поскольку это одна из отличительных особенностей Symfony, давайте-ка остановимся на этом подробнее.</p>
      <div class="section" id="understanding-the-directory-structure">
	<h2>Понимание структуры директорий<a class="headerlink" href="#understanding-the-directory-structure" title="Permalink to this headline">¶</a></h2>
	<p>Структура директорий <a class="reference internal" href="doc-glossary#term-application"><em class="xref std std-term">приложения</em></a> Symfony2 очень гибкая,
	  but the directory structure of the <em>Standard Edition</em> distribution reflects
	  the typical and recommended structure of a Symfony2 application:</p>
	<ul class="simple">
	  <li><tt class="docutils literal"><span class="pre">app/</span></tt>:    The application configuration;</li>
	  <li><tt class="docutils literal"><span class="pre">src/</span></tt>:    The project's PHP code;</li>
	  <li><tt class="docutils literal"><span class="pre">vendor/</span></tt>: The third-party dependencies;</li>
	  <li><tt class="docutils literal"><span class="pre">web/</span></tt>:    The web root directory.</li>
	</ul>
	<div class="section" id="the-web-directory">
	  <h3>The Web Directory<a class="headerlink" href="#the-web-directory" title="Permalink to this headline">¶</a></h3>
	  <p>The web root directory is the home of all public and static files like images,
	    stylesheets, and JavaScript files. It is also where each <a class="reference internal" href="doc-glossary#term-front-controller"><em class="xref std std-term">front controller</em></a>
	    lives:</p>
	  <div class="highlight-php"><div class="highlight"><pre><span class="c1">// web/app.php</span>
<span class="k">require_once</span> <span class="nx">__DIR__</span><span class="o">.</span><span class="s1">'/../app/bootstrap.php'</span><span class="p">;</span>
<span class="k">require_once</span> <span class="nx">__DIR__</span><span class="o">.</span><span class="s1">'/../app/AppKernel.php'</span><span class="p">;</span>

<span class="k">use</span> <span class="nx">Symfony\Component\HttpFoundation\Request</span><span class="p">;</span>

<span class="nv">$kernel</span> <span class="o">=</span> <span class="k">new</span> <span class="nx">AppKernel</span><span class="p">(</span><span class="s1">'prod'</span><span class="p">,</span> <span class="k">false</span><span class="p">);</span>
<span class="nv">$kernel</span><span class="o">-&gt;</span><span class="na">handle</span><span class="p">(</span><span class="nx">Request</span><span class="o">::</span><span class="na">createFromGlobals</span><span class="p">())</span><span class="o">-&gt;</span><span class="na">send</span><span class="p">();</span>
	    </pre></div>
	  </div>
	  <p>The kernel first requires the <tt class="docutils literal"><span class="pre">bootstrap.php</span></tt> file, which bootstraps the
	    framework and registers the autoloader (see below).</p>
	  <p>Like any front controller, <tt class="docutils literal"><span class="pre">app.php</span></tt> uses a Kernel Class, <tt class="docutils literal"><span class="pre">AppKernel</span></tt>, to
	    bootstrap the application.</p>
	</div>
	<div class="section" id="the-application-directory">
	  <span id="the-app-dir"></span><h3>The Application Directory<a class="headerlink" href="#the-application-directory" title="Permalink to this headline">¶</a></h3>
	  <p>The <tt class="docutils literal"><span class="pre">AppKernel</span></tt> class is the main entry point of the application
	    configuration and as such, it is stored in the <tt class="docutils literal"><span class="pre">app/</span></tt> directory.</p>
	  <p>This class must implement two methods:</p>
	  <ul class="simple">
	    <li><tt class="docutils literal"><span class="pre">registerBundles()</span></tt> must return an array of all bundles needed to run the
	      application;</li>
	    <li><tt class="docutils literal"><span class="pre">registerContainerConfiguration()</span></tt> loads the application configuration
	      (more on this later).</li>
	  </ul>
	  <p>PHP autoloading can be configured via <tt class="docutils literal"><span class="pre">app/autoload.php</span></tt>:</p>
	  <div class="highlight-php"><div class="highlight"><pre><span class="c1">// app/autoload.php</span>
<span class="k">use</span> <span class="nx">Symfony\Component\ClassLoader\UniversalClassLoader</span><span class="p">;</span>

<span class="nv">$loader</span> <span class="o">=</span> <span class="k">new</span> <span class="nx">UniversalClassLoader</span><span class="p">();</span>
<span class="nv">$loader</span><span class="o">-&gt;</span><span class="na">registerNamespaces</span><span class="p">(</span><span class="k">array</span><span class="p">(</span>
    <span class="s1">'Symfony'</span>          <span class="o">=&gt;</span> <span class="k">array</span><span class="p">(</span><span class="nx">__DIR__</span><span class="o">.</span><span class="s1">'/../vendor/symfony/src'</span><span class="p">,</span> <span class="nx">__DIR__</span><span class="o">.</span><span class="s1">'/../vendor/bundles'</span><span class="p">),</span>
    <span class="s1">'Sensio'</span>           <span class="o">=&gt;</span> <span class="nx">__DIR__</span><span class="o">.</span><span class="s1">'/../vendor/bundles'</span><span class="p">,</span>
    <span class="s1">'JMS'</span>              <span class="o">=&gt;</span> <span class="nx">__DIR__</span><span class="o">.</span><span class="s1">'/../vendor/bundles'</span><span class="p">,</span>
    <span class="s1">'Doctrine\\Common'</span> <span class="o">=&gt;</span> <span class="nx">__DIR__</span><span class="o">.</span><span class="s1">'/../vendor/doctrine-common/lib'</span><span class="p">,</span>
    <span class="s1">'Doctrine\\DBAL'</span>   <span class="o">=&gt;</span> <span class="nx">__DIR__</span><span class="o">.</span><span class="s1">'/../vendor/doctrine-dbal/lib'</span><span class="p">,</span>
    <span class="s1">'Doctrine'</span>         <span class="o">=&gt;</span> <span class="nx">__DIR__</span><span class="o">.</span><span class="s1">'/../vendor/doctrine/lib'</span><span class="p">,</span>
    <span class="s1">'Monolog'</span>          <span class="o">=&gt;</span> <span class="nx">__DIR__</span><span class="o">.</span><span class="s1">'/../vendor/monolog/src'</span><span class="p">,</span>
    <span class="s1">'Assetic'</span>          <span class="o">=&gt;</span> <span class="nx">__DIR__</span><span class="o">.</span><span class="s1">'/../vendor/assetic/src'</span><span class="p">,</span>
    <span class="s1">'Acme'</span>             <span class="o">=&gt;</span> <span class="nx">__DIR__</span><span class="o">.</span><span class="s1">'/../src'</span><span class="p">,</span>
<span class="p">));</span>
<span class="nv">$loader</span><span class="o">-&gt;</span><span class="na">registerPrefixes</span><span class="p">(</span><span class="k">array</span><span class="p">(</span>
    <span class="s1">'Twig_Extensions_'</span> <span class="o">=&gt;</span> <span class="nx">__DIR__</span><span class="o">.</span><span class="s1">'/../vendor/twig-extensions/lib'</span><span class="p">,</span>
    <span class="s1">'Twig_'</span>            <span class="o">=&gt;</span> <span class="nx">__DIR__</span><span class="o">.</span><span class="s1">'/../vendor/twig/lib'</span><span class="p">,</span>
    <span class="s1">'Swift_'</span>           <span class="o">=&gt;</span> <span class="nx">__DIR__</span><span class="o">.</span><span class="s1">'/../vendor/swiftmailer/lib/classes'</span><span class="p">,</span>
<span class="p">));</span>
<span class="nv">$loader</span><span class="o">-&gt;</span><span class="na">register</span><span class="p">();</span>
	    </pre></div>
	  </div>
	  <p>The <tt class="docutils literal"><a class="reference external" href="http://api.symfony.com/2.0/Symfony/Component/ClassLoader/UniversalClassLoader.html" title="Symfony\Component\ClassLoader\UniversalClassLoader"><span class="pre">UniversalClassLoader</span></a></tt> is used to
	    autoload files that respect either the technical interoperability <a class="reference external" href="http://groups.google.com/group/php-standards/web/psr-0-final-proposal">standards</a>
	    for PHP 5.3 namespaces or the PEAR naming <a class="reference external" href="http://pear.php.net/">convention</a> for classes. As you
	    can see here, all dependencies are stored under the <tt class="docutils literal"><span class="pre">vendor/</span></tt> directory, but
	    this is just a convention. You can store them wherever you want, globally on
	    your server or locally in your projects.</p>
	  <div class="admonition-wrapper">
	    <div class="note"></div><div class="admonition admonition-note"><p class="first admonition-title">Note</p>
	      <p class="last">If you want to learn more about the flexibility of the Symfony2
		autoloader, read the "<a class="reference internal" href="doc-cookbook-tools-autoloader"><em>How to autoload Classes</em></a>" recipe in the
		cookbook.</p>
	  </div></div>
	</div>
      </div>
      <div class="section" id="understanding-the-bundle-system">
	<h2>Understanding the Bundle System<a class="headerlink" href="#understanding-the-bundle-system" title="Permalink to this headline">¶</a></h2>
	<p>This section introduces one of the greatest and most powerful features of
	  Symfony2, the <a class="reference internal" href="doc-glossary#term-bundle"><em class="xref std std-term">bundle</em></a> system.</p>
	<p>A bundle is kind of like a plugin in other software. So why is it called
	  <em>bundle</em> and not <em>plugin</em>? Because <em>everything</em> is a bundle in Symfony2, from
	  the core framework features to the code you write for your application.
	  Bundles are first-class citizens in Symfony2. This gives you the flexibility
	  to use pre-built features packaged in third-party bundles or to distribute
	  your own bundles. It makes it easy to pick and choose which features to enable
	  in your application and optimize them the way you want.</p>
	<div class="section" id="registering-a-bundle">
	  <h3>Registering a Bundle<a class="headerlink" href="#registering-a-bundle" title="Permalink to this headline">¶</a></h3>
	  <p>An application is made up of bundles as defined in the <tt class="docutils literal"><span class="pre">registerBundles()</span></tt>
	    method of the <tt class="docutils literal"><span class="pre">AppKernel</span></tt> class:</p>
	  <div class="highlight-php"><div class="highlight"><pre><span class="c1">// app/AppKernel.php</span>
<span class="k">public</span> <span class="k">function</span> <span class="nf">registerBundles</span><span class="p">()</span>
<span class="p">{</span>
    <span class="nv">$bundles</span> <span class="o">=</span> <span class="k">array</span><span class="p">(</span>
        <span class="k">new</span> <span class="nx">Symfony\Bundle\FrameworkBundle\FrameworkBundle</span><span class="p">(),</span>
        <span class="k">new</span> <span class="nx">Symfony\Bundle\SecurityBundle\SecurityBundle</span><span class="p">(),</span>
        <span class="k">new</span> <span class="nx">Symfony\Bundle\TwigBundle\TwigBundle</span><span class="p">(),</span>
        <span class="k">new</span> <span class="nx">Symfony\Bundle\MonologBundle\MonologBundle</span><span class="p">(),</span>
        <span class="k">new</span> <span class="nx">Symfony\Bundle\SwiftmailerBundle\SwiftmailerBundle</span><span class="p">(),</span>
        <span class="k">new</span> <span class="nx">Symfony\Bundle\DoctrineBundle\DoctrineBundle</span><span class="p">(),</span>
        <span class="k">new</span> <span class="nx">Symfony\Bundle\AsseticBundle\AsseticBundle</span><span class="p">(),</span>
        <span class="k">new</span> <span class="nx">Sensio\Bundle\FrameworkExtraBundle\SensioFrameworkExtraBundle</span><span class="p">(),</span>
        <span class="k">new</span> <span class="nx">JMS\SecurityExtraBundle\JMSSecurityExtraBundle</span><span class="p">(),</span>
        <span class="k">new</span> <span class="nx">Acme\DemoBundle\AcmeDemoBundle</span><span class="p">(),</span>
    <span class="p">);</span>

    <span class="k">if</span> <span class="p">(</span><span class="nb">in_array</span><span class="p">(</span><span class="nv">$this</span><span class="o">-&gt;</span><span class="na">getEnvironment</span><span class="p">(),</span> <span class="k">array</span><span class="p">(</span><span class="s1">'dev'</span><span class="p">,</span> <span class="s1">'test'</span><span class="p">)))</span> <span class="p">{</span>
        <span class="nv">$bundles</span><span class="p">[]</span> <span class="o">=</span> <span class="k">new</span> <span class="nx">Symfony\Bundle\WebProfilerBundle\WebProfilerBundle</span><span class="p">();</span>
        <span class="nv">$bundles</span><span class="p">[]</span> <span class="o">=</span> <span class="k">new</span> <span class="nx">Symfony\Bundle\WebConfiguratorBundle\SymfonyWebConfiguratorBundle</span><span class="p">();</span>
    <span class="p">}</span>

    <span class="k">return</span> <span class="nv">$bundles</span><span class="p">;</span>
<span class="p">}</span>
	    </pre></div>
	  </div>
	  <p>In addition to the <tt class="docutils literal"><span class="pre">AcmeDemoBundle</span></tt> that we have already talked about, notice
	    that the kernel also enables the <tt class="docutils literal"><span class="pre">FrameworkBundle</span></tt>, <tt class="docutils literal"><span class="pre">DoctrineBundle</span></tt>,
	    <tt class="docutils literal"><span class="pre">SwiftmailerBundle</span></tt>, and <tt class="docutils literal"><span class="pre">AsseticBundle</span></tt> bundles. They are all part of
	    the core framework.</p>
	</div>
	<div class="section" id="configuring-a-bundle">
	  <h3>Configuring a Bundle<a class="headerlink" href="#configuring-a-bundle" title="Permalink to this headline">¶</a></h3>
	  <p>Each bundle can be customized via configuration files written in YAML, XML, or
	    PHP. Have a look at the default configuration:</p>
	  <div class="highlight-yaml"><pre># app/config/config.yml
imports:
    - { resource: parameters.ini }
    - { resource: security.yml }

framework:
    secret:          %csrf_secret%
    charset:         UTF-8
    error_handler:   null
    form:            true
    csrf_protection: true
    router:          { resource: "%kernel.root_dir%/config/routing.yml" }
    validation:      { enable_annotations: true }
    templating:      { engines: ['twig'] } #assets_version: SomeVersionScheme
    session:
        default_locale: %locale%
        lifetime:       3600
        auto_start:     true

# Twig Configuration
twig:
    debug:            %kernel.debug%
    strict_variables: %kernel.debug%

# Assetic Configuration
assetic:
    debug:          %kernel.debug%
    use_controller: false

# Doctrine Configuration
doctrine:
    dbal:
        driver:   %database_driver%
        host:     %database_host%
        dbname:   %database_name%
        user:     %database_user%
        password: %database_password%

    orm:
        auto_generate_proxy_classes: %kernel.debug%
        default_entity_manager: default
        mappings:
            auto_mapping: true

# Swiftmailer Configuration
swiftmailer:
    transport: %mailer_transport%
    host:      %mailer_host%
    username:  %mailer_user%
    password:  %mailer_password%

jms_security_extra:
    secure_controllers:  true
	      secure_all_services: false</pre>
	  </div>
	  <p>Each entry like <tt class="docutils literal"><span class="pre">framework</span></tt> defines the configuration for a specific bundle.
	    For example, <tt class="docutils literal"><span class="pre">framework</span></tt> configures the <tt class="docutils literal"><span class="pre">FrameworkBundle</span></tt> while <tt class="docutils literal"><span class="pre">swiftmailer</span></tt>
	    configures the <tt class="docutils literal"><span class="pre">SwiftmailerBundle</span></tt>.</p>
	  <p>Each <a class="reference internal" href="doc-glossary#term-environment"><em class="xref std std-term">environment</em></a> can override the default configuration by providing a
	    specific configuration file. For example, the <tt class="docutils literal"><span class="pre">dev</span></tt> environment loads the
	    <tt class="docutils literal"><span class="pre">config_dev.yml</span></tt> file, which loads the main configuration (i.e. <tt class="docutils literal"><span class="pre">config.yml</span></tt>)
	    and then modifies it to add some debugging tools:</p>
	  <div class="highlight-yaml"><pre># app/config/config_dev.yml
imports:
    - { resource: config.yml }

framework:
    router:   { resource: "%kernel.root_dir%/config/routing_dev.yml" }
    profiler: { only_exceptions: false }

web_profiler:
    toolbar: true
    intercept_redirects: false

zend:
    logger:
        priority: debug
        path:     %kernel.logs_dir%/%kernel.environment%.log

assetic:
	      use_controller: true</pre>
	  </div>
	</div>
	<div class="section" id="extending-a-bundle">
	  <h3>Extending a Bundle<a class="headerlink" href="#extending-a-bundle" title="Permalink to this headline">¶</a></h3>
	  <p>In addition to being a nice way to organize and configure your code, a bundle
	    can extend another bundle. Bundle inheritance allows you to override any existing
	    bundle in order to customize its controllers, templates, or any of its files.
	    This is where the logical names come in handy, because they abstract where
	    the resource is actually stored.</p>
	  <p>When you want to reference a file from a bundle, use this notation:
	    <tt class="docutils literal"><span class="pre">@BUNDLE_NAME/path/to/file</span></tt>; Symfony2 will resolve <tt class="docutils literal"><span class="pre">@BUNDLE_NAME</span></tt>
	    to the real path to the bundle. For instance, the logical path
	    <tt class="docutils literal"><span class="pre">@AcmeDemoBundle/Controller/DemoController.php</span></tt> would be converted to
	    <tt class="docutils literal"><span class="pre">src/Acme/DemoBundle/Controller/DemoController.php</span></tt>.</p>
	  <p>For controllers, you need to reference method names using the format
	    <tt class="docutils literal"><span class="pre">BUNDLE_NAME:CONTROLLER_NAME:ACTION_NAME</span></tt>. For instance,
	    <tt class="docutils literal"><span class="pre">AcmeDemoBundle:Welcome:index</span></tt> maps to the <tt class="docutils literal"><span class="pre">indexAction</span></tt> method from the
	    <tt class="docutils literal"><span class="pre">Acme\DemoBundle\Controller\WelcomeController</span></tt> class.</p>
	  <p>For templates, the logical name <tt class="docutils literal"><span class="pre">AcmeDemoBundle:Welcome:index.html.twig</span></tt> is
	    converted to the file path <tt class="docutils literal"><span class="pre">src/Acme/DemoBundle/Resources/views/Welcome/index.html.twig</span></tt>.
	    Templates become even more interesting when you realize they don't need to be
	    stored on the filesystem. You can easily store them in a database table for
	    instance.</p>
	  <p>Do you understand now why Symfony2 is so flexible? Share your bundles between
	    applications, store them locally or globally, your choice.</p>
	</div>
      </div>
      <div class="section" id="using-vendors">
	<span id="id1"></span><h2>Using Vendors<a class="headerlink" href="#using-vendors" title="Permalink to this headline">¶</a></h2>
	<p>Odds are that your application will depend on third-party libraries. Those
	  should be stored in the <tt class="docutils literal"><span class="pre">vendor/</span></tt> directory. This directory already contains
	  the Symfony2 libraries, the SwiftMailer library, the Doctrine ORM, the Twig
	  templating system, and some other third party libraries and bundles.</p>
      </div>
      <div class="section" id="understanding-the-cache-and-logs">
	<h2>Understanding the Cache and Logs<a class="headerlink" href="#understanding-the-cache-and-logs" title="Permalink to this headline">¶</a></h2>
	<p>Symfony2 is probably one of the fastest full-stack frameworks around. But how
	  can it be so fast if it parses and interprets tens of YAML and XML files for
	  each request? The speed is partly due to its cache system. The application
	  configuration is only parsed for the very first request and then compiled down
	  to plain PHP code stored in the <tt class="docutils literal"><span class="pre">app/cache/</span></tt> directory. In the development
	  environment, Symfony2 is smart enough to flush the cache when you change a
	  file. But in the production environment, it is your responsibility to clear
	  the cache when you update your code or change its configuration.</p>
	<p>When developing a web application, things can go wrong in many ways. The log
	  files in the <tt class="docutils literal"><span class="pre">app/logs/</span></tt> directory tell you everything about the requests
	  and help you fix the problem quickly.</p>
      </div>
      <div class="section" id="using-the-command-line-interface">
	<h2>Using the Command Line Interface<a class="headerlink" href="#using-the-command-line-interface" title="Permalink to this headline">¶</a></h2>
	<p>Each application comes with a command line interface tool (<tt class="docutils literal"><span class="pre">app/console</span></tt>)
	  that helps you maintain your application. It provides commands that boost your
	  productivity by automating tedious and repetitive tasks.</p>
	<p>Run it without any arguments to learn more about its capabilities:</p>
	<div class="highlight-bash"><div class="highlight"><pre><span class="nv">$ </span>php app/console
	  </pre></div>
	</div>
	<p>The <tt class="docutils literal"><span class="pre">--help</span></tt> option helps you discover the usage of a command:</p>
	<div class="highlight-bash"><div class="highlight"><pre><span class="nv">$ </span>php app/console router:debug --help
	  </pre></div>
	</div>
      </div>
      <div class="section" id="final-thoughts">
	<h2>Подведение итогов<a class="headerlink" href="#final-thoughts" title="Permalink to this headline">¶</a></h2>
	<p>Назовите меня сумасшедшим, но после прочтения этой части вы должны уметь
	  заставлять Symfony2 делать работу за вас. Все в Symfony2 спроектированы чтобы
	  следовать вашему пути. Так что, переименовывайте и перемещайте директории как вам угодно.
	  </p>
	<p>And that's all for the quick tour. From testing to sending emails, you still
	  need to learn a lot to become a Symfony2 master. Ready to dig into these
	  topics now? Look no further - go to the official <a class="reference internal" href="doc-book-index"><em>Book</em></a> and pick
	  any topic you want.</p>
      </div>
    </div>


    

  </div>

  <div class="navigation">
    <a accesskey="P" title="The Controller" href="<?php l('doc/quick_tour/the_big_picture')?>">
      «&nbsp;The Controller
    </a><span class="separator">|</span>
    <a accesskey="N" title="Book" href="<?php l('doc/book/index')?>">
      Book&nbsp;»
    </a>
  </div>

</div>
