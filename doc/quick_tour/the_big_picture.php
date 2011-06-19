<div class="column_02">
  <div class="box_title">
    <h1 class="title_01">Общая картина</h1>
  </div>
  
  <div class="box_quick_tour">
    <ul class="quick_tour_list">
      <li>Общая картина</li> > 
      <li><a href="<?php l('doc/quick_tour/the_view')?>">Вид</a></li> > 
      <li><a href="<?php l('doc/quick_tour/the_controller')?>">Контроллер</a></li> > 
      <li><a href="<?php l('doc/quick_tour/the_architecture')?>">Архитектура</a></li>
    </ul>
  </div>


  <div class="box_article doc_page">

    
    
    <div class="section" id="the-big-picture">
      <h1>Общая картина<a class="headerlink" href="#the-big-picture" title="Permalink to this headline">¶</a></h1>
      <p>Вы хотите попробовать новинку в области web-разработки — Symfony2, но имеете на это 10 минут или что-то около того? Этот курс молодого бойца написан специально для вас. Он рассказывает о том как быстро начать работать с Symfony2 и показывает структуру простого проекта.</p>
      <p>Если вы когда-нибудь использовали какой-либо веб-фреймворк прежде, вы будете чувствовать себя в Symfony2 как дома.</p>
      <div class="section" id="downloading-symfony2">
	<h2>Скачиваем Symfony2<a class="headerlink" href="#downloading-symfony2" title="Permalink to this headline">¶</a></h2>
	<p>В первую очередь, убедитесь что у вас установлен и настроен как минимум PHP 5.3.0 и вебсервер (например apache).</p>
	<p>Готовы? Начните с загрузки "<a class="reference external" href="http://symfony.com/download">Symfony2 Standard Edition</a>", 
	  <a class="reference internal" href="glossary#term-distribution"><em class="xref std std-term">дистрибутива</em></a>  Symfony настроенного для большинства потребностей, а так же содержащий код, показывающий как использовать Symfony2.</p>
	<p>После распаковки архива в корневую директорию веб-сервера, вы должны получить папку <tt class="docutils literal"><span class="pre">Symfony/</span></tt>, в которой содержится следующее:</p>
	<div class="highlight-text"><div class="highlight">
	<pre>www/ &lt;- ваш корневой каталог
    Symfony/ &lt;- распакованных архив
        app/
            cache/
            config/
            logs/
        src/
            Acme/
                DemoBundle/
                    Controller/
                    Resources/
        vendor/
            symfony/
            doctrine/
            ...
        web/
            app.php
	</pre>
	</div>
	</div>
      </div>
      <div class="section" id="checking-the-configuration">
	<h2>Проверяем конфигурацию<a class="headerlink" href="#checking-the-configuration" title="Permalink to this headline">¶</a></h2>
	<p>Symfony2 поставляется с визуальным приложением для тестирования конфигурации сервера, это поможет вам избежать головную боль с конфигурацией веб-сервера или PHP. Используйте следующий URL чтобы увидеть анализ ваших настроек:</p>
	<div class="highlight-text"><div class="highlight"><pre>http://localhost/Symfony/web/config.php</pre></div>
	</div>
	<p>Если в списке есть ошибки - исправьте их. Вы так же можете настроить сервер, следуя рекомендациям.
		Когда все будет исправлено, кликните на "Go to the Welcome page" чтобы перейти на вашу первую
		"реальную" страницу на Symfony2:</p>
	<div class="highlight-text"><div class="highlight"><pre>http://localhost/Symfony/web/app_dev.php/</pre></div>
	</div>
	<p>Symfony2 должна поприветствовать и поздравить вас за выполненную тяжелую работу!</p>
	<img alt="welcome.jpg" src="<?php l()?>doc/_images/welcome.jpg">
      </div>
      <div class="section" id="understanding-the-fundamentals">
	<h2>Понимание основ<a class="headerlink" href="#understanding-the-fundamentals" title="Permalink to this headline">¶</a></h2>
	<p>Одна из главных целей фреймворка - следовать концепции <a class="reference external" href="http://ru.wikipedia.org/wiki/Разделение_ответственности">разделения ответственности</a>.
	  Это делает ваш код организованным и позволяет эволюционировать приложению,
	  избегая смеси запросов к базе, HTML-тэгов и бизнес-логики в одном скрипте.
	  Чтобы достичь эту цель с Symfony2 вы должны узнать несколько фундаментальных
	  концепций и терминов.</p>
	<div class="admonition-wrapper">
	  <div class="tip"></div><div class="admonition admonition-tip"><p class="first admonition-title">Tip</p>
	    <p class="last">Хотите доказательств, что использование фреймворка лучше
	    чем смеси всего в одном скрипте? Прочтите главу "<a class="reference internal" href="../book/from_flat_php_to_symfony2.html"><em>От плоского PHP кода до Symfony2</em></a>"</p>
	</div></div>
	<p>Базовое издание идет с примером кода, что позволяет узнать вам больше о
	главных концепциях Symfony2. Перейдите по следующему URL, чтобы Symfony2 
	поприветствовала вас (замените <em>Fabien</em> своим именем):</p>
	<div class="highlight-text"><div class="highlight"><pre>http://localhost/Symfony/web/app_dev.php/demo/hello/Fabien</pre></div>
	</div>
	<p>Что здесь произошло? Давайте проанализируем URL:</p>
	<ul class="simple">
	  <li><tt class="docutils literal"><span class="pre">app_dev.php</span></tt>: Это <a class="reference internal" href="../glossary.html#term-front-controller"><em class="xref std std-term">контроллер входа (front controller)</em></a>. Это точка входа в приложение
	  	и оно отвечает на все запросы пользователя;</li>
	  <li><tt class="docutils literal"><span class="pre">/demo/hello/Fabien</span></tt>: Это <em>виртуальный путь</em> к ресурсу, который запрашивает пользователь.</li>
	</ul>
	<p>Ваша задача, как разработчика, заключается в том, чтобы написать код, который связывает <em>запрос</em> (<tt class="docutils literal"><span class="pre">/demo/hello/Fabien</span></tt>) с <em>ресурсом</em>
	  (<tt class="docutils literal"><span class="pre">Hello</span> <span class="pre">Fabien!</span></tt>).</p>
	<div class="section" id="routing">
	  <h3>Маршрутизация<a class="headerlink" href="#routing" title="Permalink to this headline">¶</a></h3>
	  <p>Symfony2 направляет запрос на код, который сравнивает текущий URL с
	  настроенными шаблонами. По умолчанию шаблоны (называемые маршрутами)
	  задаются в файле <tt class="docutils literal"><span class="pre">app/config/routing.yml</span></tt>:</p>
	  <div class="highlight-yaml"><div class="highlight">
	  <pre><span class="c1"># app/config/routing.yml</span>
<span class="l-Scalar-Plain">_welcome</span><span class="p-Indicator">:</span>
    <span class="l-Scalar-Plain">pattern</span><span class="p-Indicator">:</span>  <span class="l-Scalar-Plain">/</span>
    <span class="l-Scalar-Plain">defaults</span><span class="p-Indicator">:</span> <span class="p-Indicator">{</span> <span class="nv">_controller</span><span class="p-Indicator">:</span> <span class="nv">AcmeDemoBundle</span><span class="p-Indicator">:</span><span class="nv">Welcome</span><span class="p-Indicator">:</span><span class="nv">index</span> <span class="p-Indicator">}</span>

<span class="l-Scalar-Plain">_demo</span><span class="p-Indicator">:</span>
    <span class="l-Scalar-Plain">resource</span><span class="p-Indicator">:</span> <span class="s">"@AcmeDemoBundle/Controller/DemoController.php"</span>
    <span class="l-Scalar-Plain">type</span><span class="p-Indicator">:</span>     <span class="l-Scalar-Plain">annotation</span>
    <span class="l-Scalar-Plain">prefix</span><span class="p-Indicator">:</span>   <span class="l-Scalar-Plain">/demo</span>
</pre>
	    </div>
	  </div>
	  <p>Три первые линии (после комментария) задают код, который будет запущен
	  при запросе ресурса "<tt class="docutils literal"><span class="pre">/</span></tt>" (т.е. страницы приветствия).
	  После запроса будет запущен контроллер <tt class="docutils literal"><span class="pre">AcmeDemoBundle:Welcome:index</span></tt>.</p>
	  <div class="admonition-wrapper">
	    <div class="tip"></div><div class="admonition admonition-tip"><p class="first admonition-title">Tip</p>
	      <p class="last">В стандартной поставке Symfony2 использует <a class="reference external" href="http://www.yaml.org/">YAML</a> для файлов конфигурации, но Symfony2 так же поддерживает XML, PHP и аннотации "из коробки".
	      Различные форматы совместимы и могут быть взаимозаменяемы внутри приложения.
	      Так же быстродействие вашего приложения не зависит от формата конфигурации,
	      который вы выберете - все будет закешировано при первом запросе.</p>
	  </div></div>
	</div>
	<div class="section" id="controllers">
	  <h3>Контроллеры<a class="headerlink" href="#controllers" title="Permalink to this headline">¶</a></h3>
	  <p>Контроллер обрабатывает входящий <em>запрос</em> и возвращает <em>ответ</em> (чаще всего HTML-код).
	  Вместо использования глобальных переменных и функций (таких как <tt class="docutils literal"><span class="pre">$_GET</span></tt>
	    или <tt class="docutils literal"><span class="pre">header()</span></tt>) для управления HTTP-сообщениями
	    Symfony использует объекты <tt class="docutils literal"><a class="reference external" href="http://api.symfony.com/2.0/Symfony/Component/HttpFoundation/Request.html" title="Symfony\Component\HttpFoundation\Request"><span class="pre">Request</span></a></tt> и
	    <tt class="docutils literal"><a class="reference external" href="http://api.symfony.com/2.0/Symfony/Component/HttpFoundation/Response.html" title="Symfony\Component\HttpFoundation\Response"><span class="pre">Response</span></a></tt>.
	    Простейший контроллер, который создает ответ на базе запроса:</p>
	  <div class="highlight-php"><div class="highlight">
	  <pre><span class="k">use</span> <span class="nx">Symfony\Component\HttpFoundation\Response</span><span class="p">;</span>

<span class="nv">$name</span> <span class="o">=</span> <span class="nv">$request</span><span class="o">-&gt;</span><span class="na">query</span><span class="o">-&gt;</span><span class="na">get</span><span class="p">(</span><span class="s1">'name'</span><span class="p">);</span>

<span class="k">return</span> <span class="k">new</span> <span class="nx">Response</span><span class="p">(</span><span class="s1">'Hello '</span><span class="o">.</span><span class="nv">$name</span><span class="p">,</span> <span class="mi">200</span><span class="p">,</span> <span class="k">array</span><span class="p">(</span><span class="s1">'Content-Type'</span> <span class="o">=&gt;</span> <span class="s1">'text/plain'</span><span class="p">));</span></pre></div>
	  </div>
	  <div class="admonition-wrapper">
	    <div class="note"></div><div class="admonition admonition-note"><p class="first admonition-title">Note</p>
	      <p class="last">Не обманывайте себя простотой концепций и силой, которую
	      они содержат. Прочтите главу
	      "<a class="reference internal" href="../book/http_fundamentals.html"><em>Основы Symfony2 и HTTP</em></a>"
	      чтобы узнать больше о том как Symfony2 оборачивает HTTP и почему это
	      делает использование проще и мощнее в тоже время.</p>
	  </div></div>
	  <p>Symfony2 выбирает контроллер базируясь на значении <tt class="docutils literal"><span class="pre">_controller</span></tt>
	  из конфигурации маршрутизации: <tt class="docutils literal"><span class="pre">AcmeDemoBundle:Welcome:index</span></tt>.
	  Это - <em>логическое имя</em> и оно указывает на метод <tt class="docutils literal"><span class="pre">indexAction</span></tt> 
	  класса <tt class="docutils literal"><span class="pre">Acme\DemoBundle\Controller\WelcomeController</span></tt>:</p>
	  <div class="highlight-php"><div class="highlight">
	  <pre><span class="c1">// src/Acme/DemoBundle/Controller/WelcomeController.php</span>
<span class="k">namespace</span> <span class="nx">Acme\DemoBundle\Controller</span><span class="p">;</span>

<span class="k">use</span> <span class="nx">Symfony\Bundle\FrameworkBundle\Controller\Controller</span><span class="p">;</span>

<span class="k">class</span> <span class="nc">WelcomeController</span> <span class="k">extends</span> <span class="nx">Controller</span>
<span class="p">{</span>
    <span class="k">public</span> <span class="k">function</span> <span class="nf">indexAction</span><span class="p">()</span>
    <span class="p">{</span>
        <span class="k">return</span> <span class="nv">$this</span><span class="o">-&gt;</span><span class="na">render</span><span class="p">(</span><span class="s1">'AcmeDemoBundle:Welcome:index.html.twig'</span><span class="p">);</span>
    <span class="p">}</span>
<span class="p">}</span>
</pre></div>
	  </div>
	  <div class="admonition-wrapper">
	    <div class="tip"></div><div class="admonition admonition-tip"><p class="first admonition-title">Tip</p>
	      <p class="last">Вы могли бы использовать <tt class="docutils literal"><span class="pre">Acme\DemoBundle\Controller\WelcomeController::indexAction</span></tt>
	      для значения <tt class="docutils literal"><span class="pre">_controller</span></tt>,
	      но если следовать простым соглашениям логическое имя может быть более
	      простым и более гибким.</p>
	  </div></div>
	  <p>Класс контроллера расширяет встроенный класс <tt class="docutils literal"><span class="pre">Controller</span></tt>,
	  который представляет удобные методы, такой как <tt class="docutils literal"><a class="reference external" href="http://api.symfony.com/2.0/Symfony/Bundle/FrameworkBundle/Controller/Controller.html#render()" title="Symfony\Bundle\FrameworkBundle\Controller\Controller::render()"><span class="pre">render()</span></a></tt>
	  который загружает и отображает шаблон (<tt class="docutils literal"><span class="pre">AcmeDemoBundle:Welcome:index.html.twig</span></tt>).
	  Возвращаемое значение - это объект Response, наполненный отображаемым контентом.
	  Так, если вам нужно, Response может быть настроен до отправки браузеру:</p>
	  <div class="highlight-php"><div class="highlight">
	  <pre><span class="k">public</span> <span class="k">function</span> <span class="nf">indexAction</span><span class="p">()</span>
<span class="p">{</span>
    <span class="nv">$response</span> <span class="o">=</span> <span class="nv">$this</span><span class="o">-&gt;</span><span class="na">render</span><span class="p">(</span><span class="s1">'AcmeDemoBundle:Welcome:index.txt.twig'</span><span class="p">);</span>
    <span class="nv">$response</span><span class="o">-&gt;</span><span class="na">headers</span><span class="o">-&gt;</span><span class="na">set</span><span class="p">(</span><span class="s1">'Content-Type'</span><span class="p">,</span> <span class="s1">'text/plain'</span><span class="p">);</span>

    <span class="k">return</span> <span class="nv">$response</span><span class="p">;</span>
<span class="p">}</span>
</pre></div>
	  </div>
	  <div class="admonition-wrapper">
	    <div class="tip"></div><div class="admonition admonition-tip"><p class="first admonition-title">Tip</p>
	      <p class="last">Расширять класс <tt class="docutils literal"><span class="pre">Controller</span></tt> не обязательно.
	      В сущности, контроллер может быть функцией на плоском PHP или даже PHP-замыканием.
	      Глава "<a class="reference internal" href="../book/controller.html"><em>Контроллер</em></a>"
	      расскажет вам все о контроллерах Symfony2.</p>
	  </div></div>
	  <p>Имя шаблона <tt class="docutils literal"><span class="pre">AcmeDemoBundle:Welcome:index.html.twig</span></tt> - это логическое имя
	  и оно указывает на файл <tt class="docutils literal"><span class="pre">src/Acme/DemoBundle/Resources/views/Welcome/index.html.twig</span></tt>.
	  Глава о пакетах расскажет вам почему это удобно.</p>
	  <p>А сейчас, давайте снова взглянем на конфигурацию маршрутизации:</p>
	  <div class="highlight-yaml"><div class="highlight">
	  <pre><span class="c1"># app/config/routing.yml</span>
<span class="l-Scalar-Plain">_demo</span><span class="p-Indicator">:</span>
    <span class="l-Scalar-Plain">resource</span><span class="p-Indicator">:</span> <span class="s">"@AcmeDemoBundle/Controller/DemoController.php"</span>
    <span class="l-Scalar-Plain">type</span><span class="p-Indicator">:</span>     <span class="l-Scalar-Plain">annotation</span>
    <span class="l-Scalar-Plain">prefix</span><span class="p-Indicator">:</span>   <span class="l-Scalar-Plain">/demo</span>
</pre></div>
	  </div>
	  <p>Symfony2 может читать информацию о маршрутизации в форматах YAML, XML, PHP
	  или даже встроенных в PHP аннотаций. Здесь <em>логическое имя</em> <em>logical name</em> is <tt class="docutils literal"><span class="pre">@AcmeDemoBundle/Controller/DemoController.php</span></tt>
	  ссылается на файл <tt class="docutils literal"><span class="pre">src/Acme/DemoBundle/Controller/DemoController.php</span></tt>.
	  В этом файле маршруты заданы как аннотации к методам:</p>
	  <div class="highlight-php"><div class="highlight">
	  <pre><span class="c1">// src/Acme/DemoBundle/Controller/DemoController.php</span>
<span class="k">use</span> <span class="nx">Sensio\Bundle\FrameworkExtraBundle\Configuration\Route</span><span class="p">;</span>
<span class="k">use</span> <span class="nx">Sensio\Bundle\FrameworkExtraBundle\Configuration\Template</span><span class="p">;</span>

<span class="k">class</span> <span class="nc">DemoController</span> <span class="k">extends</span> <span class="nx">Controller</span>
<span class="p">{</span>
    <span class="sd">/**</span>
<span class="sd">     * @Route("/hello/{name}", name="_demo_hello")</span>
<span class="sd">     * @Template()</span>
<span class="sd">     */</span>
    <span class="k">public</span> <span class="k">function</span> <span class="nf">helloAction</span><span class="p">(</span><span class="nv">$name</span><span class="p">)</span>
    <span class="p">{</span>
        <span class="k">return</span> <span class="k">array</span><span class="p">(</span><span class="s1">'name'</span> <span class="o">=&gt;</span> <span class="nv">$name</span><span class="p">);</span>
    <span class="p">}</span>

    <span class="c1">// ...</span>
<span class="p">}</span>
</pre></div>
	  </div>
	  <p>Аннотация <tt class="docutils literal"><span class="pre">@Route()</span></tt> задает новый маршрут с
	  шаблоном <tt class="docutils literal"><span class="pre">/hello/{name}</span></tt>, который запускает метод
	  <tt class="docutils literal"><span class="pre">helloAction</span></tt> при совпадении.
	  Строка, обернутая в фигурные скобки, такая как <tt class="docutils literal"><span class="pre">{name}</span></tt>
	  называется placeholder. Как вы можете видеть ее значение доступно через аргумент <tt class="docutils literal"><span class="pre">$name</span></tt>.</p>
	  <div class="admonition-wrapper">
	    <div class="note"></div><div class="admonition admonition-note"><p class="first admonition-title">Note</p>
	      <p class="last">Даже если аннотации не поддерживаются PHP, вы можете
	      их широко использовать в Symfony2 как удобный способ хранить настройки
	      рядом с кодом.</p>
	  </div></div>
	  <p>Если вы внимательно посмотрите на код действия, то сможете увидеть,
	  что вместо вывода шаблона как раньше, теперь мы просто возвращаем массив
	  параметров. Аннотация <tt class="docutils literal"><span class="pre">@Template()</span></tt>
	  говорит Symfony2 отобразить шаблон, передавая каждый параметр массива в шаблон.
	  Название шаблона следует из имени контроллера. Так, в этом примере, 
	  отобразится шаблон <tt class="docutils literal"><span class="pre">AcmeDemoBundle:Demo:hello.html.twig</span></tt>
	  (расположенный в <tt class="docutils literal"><span class="pre">src/Acme/DemoBundle/Resources/views/Demo/hello.html.twig</span></tt>).</p>
	  <div class="admonition-wrapper">
	    <div class="tip"></div><div class="admonition admonition-tip"><p class="first admonition-title">Tip</p>
	      <p class="last">Аннотации <tt class="docutils literal"><span class="pre">@Route()</span></tt> и <tt class="docutils literal"><span class="pre">@Template()</span></tt> более мощные чем показано в этом примере. Узнайте больше о
	      "<a class="reference external" href="http://bundles.symfony-reloaded.org/frameworkextrabundle/">аннотациях в контроллерах</a>"
	      в официальной документации.</p>
	  </div></div>
	</div>
	<div class="section" id="templates">
	  <h3>Шаблоны<a class="headerlink" href="#templates" title="Permalink to this headline">¶</a></h3>
	  <p>Контроллер отображает шаблон <tt class="docutils literal"><span class="pre">src/Acme/DemoBundle/Resources/views/Demo/hello.html.twig</span></tt>
	  (или <tt class="docutils literal"><span class="pre">AcmeDemoBundle:Demo:hello.html.twig</span></tt>
	  если вы предпочитаете логические имена):</p>
	  <div class="highlight-jinja"><div class="highlight">
	  <pre><span class="c">{# src/Acme/DemoBundle/Resources/views/Demo/hello.html.twig #}</span><span class="x"></span>
<span class="cp">{%</span> <span class="k">extends</span> <span class="s2">"AcmeDemoBundle::layout.html.twig"</span> <span class="cp">%}</span><span class="x"></span>

<span class="cp">{%</span> <span class="k">block</span> <span class="nv">title</span> <span class="s2">"Hello "</span> <span class="o">~</span> <span class="nv">name</span> <span class="cp">%}</span><span class="x"></span>

<span class="cp">{%</span> <span class="k">block</span> <span class="nv">content</span> <span class="cp">%}</span><span class="x"></span>
<span class="x">    &lt;h1&gt;Hello </span><span class="cp">{{</span> <span class="nv">name</span> <span class="cp">}}</span><span class="x">!&lt;/h1&gt;</span>
<span class="cp">{%</span> <span class="k">endblock</span> <span class="cp">%}</span><span class="x"></span>
</pre></div>
	  </div>
	  <p>По умолчанию, Symfony2 использует <a class="reference external" href="http://www.twig-project.org/">Twig</a>
	  в качестве шаблнизатора, но вы так же можете использовать обычный PHP если
	  вам так больше нравится. В следующих главах мы поговорим о том как шаблоны
	  работают в Symfony2.</p>
	</div>
	<div class="section" id="bundles">
	  <h3>Пакеты (bundles)<a class="headerlink" href="#bundles" title="Permalink to this headline">¶</a></h3>
	  <p>Вы должно быть удивлены, тем что видите слово <a class="reference internal" href="../glossary.html#term-bundle"><em class="xref std std-term">пакет</em></a> так часто. Весь код вашего приложения находится в пакетах.
	  В терминологии Symfony2 пакет представляет собой структурированный набор
	  файлов (файлы PHP, стили, JavaScript'ы, картинки, ...) которые выполняют
	  одну функцию (блог, форум, ...) и которыми можно легко поделиться с
	  другими разработчиками. Пока мы работали только с одним пакетом - 
	  <tt class="docutils literal"><span class="pre">AcmeDemoBundle</span></tt>.
	  Вы узнаете больше о пакетах в последней главе данного урока.</p>
	</div>
      </div>
      <div class="section" id="working-with-environments">
	<h2>Работа с окружениями<a class="headerlink" href="#working-with-environments" title="Permalink to this headline">¶</a></h2>
	<p>Сейчас, когда вы имеете лучшее понимание работы Symfony2, обратите внимание
	на нижнию часть страницы; вы увидите маленькую панель с логотипом Symfony2.
	Она называется "Веб-панелью отладки" ("Web Debug Toolbar") и это лучший друг разработчика.
	Но эта только вершина айсберга; нажмите на странное шестнадцатеричное число
	чтобы открыть еще один очень полезный инструмент отладки: профайлер.</p>
	<p>Конечно, вы не хотите видеть эти инструменты, когда вы развертываете
	приложение на рабочий сервер. Вот почему вы найдете еще один контроллер
	входа в папке <tt class="docutils literal"><span class="pre">web/</span></tt>
	 (<tt class="docutils literal"><span class="pre">app.php</span></tt>), он 
	 оптимизирован для работы в рабочем окружении:</p>
	<div class="highlight-text"><div class="highlight"><pre>http://localhost/Symfony/web/app.php/demo/hello/Fabien</pre></div>
	</div>
	<p>И если вы используете Apache с включенным <tt class="docutils literal"><span class="pre">mod_rewrite</span></tt>,
	 вы можете опустить часть URL с 
	  <tt class="docutils literal"><span class="pre">app.php</span></tt>:</p>
	<div class="highlight-text"><div class="highlight"><pre>http://localhost/Symfony/web/demo/hello/Fabien</pre></div>
	</div>
	<p>Но гораздо лучше, на рабочем сервере, установить корнем веб-сервера
	папку <tt class="docutils literal"><span class="pre">web/</span></tt>, чтобы
	защитить файлы и сделать более красивый URL:</p>
	<div class="highlight-text"><div class="highlight"><pre>http://localhost/demo/hello/Fabien</pre></div>
	</div>
	<p>Чтобы сделать ответ приложение быстрым, Symfony2 сохраняет кеш в папку
	<tt class="docutils literal"><span class="pre">app/cache/</span></tt>. 
	В окружении разработки (<tt class="docutils literal"><span class="pre">app_dev.php</span></tt>),
	кэш очищается автоматически, когда вы производите какое-либо изменение
	в коде. Но в рабочем окружении (<tt class="docutils literal"><span class="pre">app.php</span></tt>),
	где производительность это самое важное, этого не происходит.
	Вот почему вы всегда должны использовать окружение разработки, когда
	создаете ваше приложение.</p>
	<p>Разные <a class="reference internal" href="../glossary.html#term-environment"><em class="xref std std-term">окружения</em></a>
	одного приложения различаются только в своей конфигурации. На самом деле, одна конфигурация может наследоваться от другой:</p>
	<div class="highlight-yaml"><div class="highlight">
	<pre><span class="c1"># app/config/config_dev.yml</span>
<span class="l-Scalar-Plain">imports</span><span class="p-Indicator">:</span>
    <span class="p-Indicator">-</span> <span class="p-Indicator">{</span> <span class="nv">resource</span><span class="p-Indicator">:</span> <span class="nv">config.yml</span> <span class="p-Indicator">}</span>

<span class="l-Scalar-Plain">web_profiler</span><span class="p-Indicator">:</span>
    <span class="l-Scalar-Plain">toolbar</span><span class="p-Indicator">:</span> <span class="l-Scalar-Plain">true</span>
    <span class="l-Scalar-Plain">intercept_redirects</span><span class="p-Indicator">:</span> <span class="l-Scalar-Plain">false</span>
</pre></div>
	</div>
	<p>Окружение <tt><span class="pre">dev</span></tt> (заданное в <tt class="docutils literal"><span class="pre">config_dev.yml</span></tt>)
	наследуется от глобального файла <tt class="docutils literal"><span class="pre">config.yml</span></tt> и расширяет его, включая
	веб-панель отладки.</p>
      </div>
      <div class="section" id="final-thoughts">
	<h2>Подведение итогов<a class="headerlink" href="#final-thoughts" title="Permalink to this headline">¶</a></h2>
	<p>Поздравляю! Вы почувствовали вкус кода Symfony2. Это было не тяжело, правда?
	Вы должны узнать еще многое, но вы уже можете видеть как Symfony2 позволяет
	делать сайты лучше и быстрее. Если вы хотите узнать больше о Symfony2 погрузитесь
	в следующую главу: "Вид".</p>
      </div>
    </div>    

  </div>

  <div class="navigation">
      Краткий обзор
    <span class="separator">|</span>
    <a accesskey="N" title="The View" href="<?php l('doc/quick_tour/the_view')?>">
      Вид&nbsp;»
    </a>
  </div>

</div>

</div>
