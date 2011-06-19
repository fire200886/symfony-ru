<div class="column_02">

  <div class="box_title">
    <h1 class="title_01">Вид</h1>
  </div>
  
  <div class="box_quick_tour">
    <ul class="quick_tour_list clear_fix">
      <li><a href="<?php l('doc/quick_tour/the_big_picture')?>">Общая картина</a></li> > 
      <li>Вид</li> > 
      <li><a href="<?php l('doc/quick_tour/the_controller')?>">Контроллер</a></li> > 
      <li><a href="<?php l('doc/quick_tour/the_architecture')?>">Архитектура</a></li>
    </ul>
  </div>


  <div class="box_article doc_page">

    
    
    <div class="section" id="the-view">
      <h1>Вид<a class="headerlink" href="#the-view" title="Permalink to this headline">¶</a></h1>
      <p>После прочтения первой части вы решили, что Symfony2 стоит еще 10 минут.
      Отличное решение! Во второй части вы узнаете больше о шаблонизаторе
      Symfony2, <a class="reference external" href="http://www.twig-project.org/">Twig</a>.
      Twig гибкий, быстрый и защищенный шаблонизатор для PHP. Он делает ваши шаблоны
      более читаемыми и краткими; он также делает их более дружелюбными для веб-дизайнеров.</p>
      <div class="admonition-wrapper">
	<div class="note"></div><div class="admonition admonition-note"><p class="first admonition-title">Note</p>
	  <p class="last">Вместо Twig, вы также можете использовать <a class="reference internal" href="../cookbook/templating/PHP.html"><em>PHP</em></a>
	  для своих шаблонов. Оба шаблонизатора поддерживаются в Symfony2.</p>
      </div></div>
      <div class="section" id="getting-familiar-with-twig">
	<h2>Знакомство с Twig<a class="headerlink" href="#getting-familiar-with-twig" title="Permalink to this headline">¶</a></h2>
	<div class="admonition-wrapper">
	  <div class="tip"></div><div class="admonition admonition-tip"><p class="first admonition-title">Tip</p>
	    <p class="last">Если вы хотите изучить Twig, мы настоятельно рекомендуем вам
	    прочесть официальную <a class="reference external" href="http://www.twig-project.org/documentation">документацию</a>.
	    Эта глава лишь краткий осмотр главных концепций.</p>
	</div></div>
	<p>Шаблон Twig - это текстовый файл, который может генерировать любой
	 текстовый формат (HTML, XML, CSV, LaTeX, ...). Twig предлагает два вида
	 разделителей:</p>
	<ul class="simple">
	  <li><tt class="docutils literal"><span class="pre">{{</span> <span class="pre">...</span> <span class="pre">}}</span></tt>: Выводит переменную или результат выражения;</li>
	  <li><tt class="docutils literal"><span class="pre">{%</span> <span class="pre">...</span> <span class="pre">%}</span></tt>: Тэг, который
	   управляет логикой шаблона; он используется для запуска циклов 
	   <tt class="docutils literal"><span class="pre">for</span></tt>
	   или выражений <tt class="docutils literal"><span class="pre">if</span></tt>.</li>
	</ul>
	<p>Ниже приведен минимальный шаблон, который показывает основы:</p>
	<div class="highlight-html+jinja"><div class="highlight"><pre><span class="cp">&lt;!DOCTYPE html&gt;</span>
<span class="nt">&lt;html&gt;</span>
    <span class="nt">&lt;head&gt;</span>
        <span class="nt">&lt;title&gt;</span>My Webpage<span class="nt">&lt;/title&gt;</span>
    <span class="nt">&lt;/head&gt;</span>
    <span class="nt">&lt;body&gt;</span>
        <span class="nt">&lt;h1&gt;</span><span class="cp">{{</span> <span class="nv">page_title</span> <span class="cp">}}</span><span class="nt">&lt;/h1&gt;</span>

        <span class="nt">&lt;ul</span> <span class="na">id=</span><span class="s">"navigation"</span><span class="nt">&gt;</span>
            <span class="cp">{%</span> <span class="k">for</span> <span class="nv">item</span> <span class="k">in</span> <span class="nv">navigation</span> <span class="cp">%}</span>
                <span class="nt">&lt;li&gt;&lt;a</span> <span class="na">href=</span><span class="s">"</span><span class="cp">{{</span> <span class="nv">item.href</span> <span class="cp">}}</span><span class="s">"</span><span class="nt">&gt;</span><span class="cp">{{</span> <span class="nv">item.caption</span> <span class="cp">}}</span><span class="nt">&lt;/a&gt;&lt;/li&gt;</span>
            <span class="cp">{%</span> <span class="k">endfor</span> <span class="cp">%}</span>
        <span class="nt">&lt;/ul&gt;</span>
    <span class="nt">&lt;/body&gt;</span>
<span class="nt">&lt;/html&gt;</span>
	  </pre></div>
	</div>
	<div class="admonition-wrapper">
	  <div class="tip"></div><div class="admonition admonition-tip"><p class="first admonition-title">Tip</p>
	    <p class="last">Комментарии могут быть включены шаблон используя раделитель <tt class="docutils literal"><span class="pre">{#</span> <span class="pre">...</span> <span class="pre">#}</span></tt>.</p>
	</div></div>
	<p>Чтобы отобразить шаблон используйте метод <tt class="docutils literal"><span class="pre">render</span></tt> из контроллера и
	передайте любые переменные, требуемые в шаблоне:</p>
	<div class="highlight-php"><div class="highlight"><pre><span class="nv">$this</span><span class="o">-&gt;</span><span class="na">render</span><span class="p">(</span><span class="s1">'AcmeDemoBundle:Demo:hello.html.twig'</span><span class="p">,</span> <span class="k">array</span><span class="p">(</span>
    <span class="s1">'name'</span> <span class="o">=&gt;</span> <span class="nv">$name</span><span class="p">,</span>
<span class="p">));</span>
	  </pre></div>
	</div>
	<p>Переменные, передаваемые в шаблон могут быть строками, массивами
	или даже объектами. Twig скрывает разницу между ними и позволяет
	получить доступ к "аттрибутам" через точку (<tt class="docutils literal"><span class="pre">.</span></tt>):</p>
	<div class="highlight-jinja"><div class="highlight"><pre><span class="c">{# array('name' =&gt; 'Fabien') #}</span><span class="x"></span>
<span class="cp">{{</span> <span class="nv">name</span> <span class="cp">}}</span><span class="x"></span>

<span class="c">{# array('user' =&gt; array('name' =&gt; 'Fabien')) #}</span><span class="x"></span>
<span class="cp">{{</span> <span class="nv">user.name</span> <span class="cp">}}</span><span class="x"></span>

<span class="c">{# force array lookup #}</span><span class="x"></span>
<span class="cp">{{</span> <span class="nv">user</span><span class="o">[</span><span class="s1">'name'</span><span class="o">]</span> <span class="cp">}}</span><span class="x"></span>

<span class="c">{# array('user' =&gt; new User('Fabien')) #}</span><span class="x"></span>
<span class="cp">{{</span> <span class="nv">user.name</span> <span class="cp">}}</span><span class="x"></span>
<span class="cp">{{</span> <span class="nv">user.getName</span> <span class="cp">}}</span><span class="x"></span>

<span class="c">{# force method name lookup #}</span><span class="x"></span>
<span class="cp">{{</span> <span class="nv">user.name</span><span class="o">()</span> <span class="cp">}}</span><span class="x"></span>
<span class="cp">{{</span> <span class="nv">user.getName</span><span class="o">()</span> <span class="cp">}}</span><span class="x"></span>

<span class="c">{# pass arguments to a method #}</span><span class="x"></span>
<span class="cp">{{</span> <span class="nv">user.date</span><span class="o">(</span><span class="s1">'Y-m-d'</span><span class="o">)</span> <span class="cp">}}</span><span class="x"></span>
	  </pre></div>
	</div>
	<div class="admonition-wrapper">
	  <div class="note"></div><div class="admonition admonition-note"><p class="first admonition-title">Note</p>
	    <p class="last">Важно понимать, что фигурные скобки не являются
	    частью переменной, но являются частью выражения вывода.
	    Если вы хотите получить доступ к переменной внутри тегов не
	    ставьте фигурные скобки.</p>
	</div></div>
      </div>
      <div class="section" id="decorating-templates">
	<h2>Декорирование шаблонов<a class="headerlink" href="#decorating-templates" title="Permalink to this headline">¶</a></h2>
	<p>Часто шаблоны в проекте используеют общие элементы, такие как,
	например, шапка (header) и футер. В Symfony2 эта проблема решается
	под другому: один шаблон может быть декорирован другим. Это работает
	как классы в PHP: наследование шаблонов позволяет вам создать базовый
	"layout", содержащий общие элементы сайта и задать "блоки" ("blocks"),
	которые могут быть перегружены в дочерних шаблонах.</p>
	<p>Шаблон <tt class="docutils literal"><span class="pre">hello.html.twig</span></tt>
	наследуется от <tt class="docutils literal"><span class="pre">layout.html.twig</span></tt>
	благодаря тегу <tt class="docutils literal"><span class="pre">extends</span></tt>:</p>
	<div class="highlight-html+jinja"><div class="highlight"><pre><span class="c">{# src/Acme/DemoBundle/Resources/views/Demo/hello.html.twig #}</span>
<span class="cp">{%</span> <span class="k">extends</span> <span class="s2">"AcmeDemoBundle::layout.html.twig"</span> <span class="cp">%}</span>

<span class="cp">{%</span> <span class="k">block</span> <span class="nv">title</span> <span class="s2">"Hello "</span> <span class="o">~</span> <span class="nv">name</span> <span class="cp">%}</span>

<span class="cp">{%</span> <span class="k">block</span> <span class="nv">content</span> <span class="cp">%}</span>
    <span class="nt">&lt;h1&gt;</span>Hello <span class="cp">{{</span> <span class="nv">name</span> <span class="cp">}}</span>!<span class="nt">&lt;/h1&gt;</span>
<span class="cp">{%</span> <span class="k">endblock</span> <span class="cp">%}</span>
	  </pre></div>
	</div>
	<p>Аннотация <tt class="docutils literal"><span class="pre">AcmeDemoBundle::layout.html.twig</span></tt>
	звучит знакомо, не правда ли? Такие же аннотации используются
	для обычных шаблонов. Часть <tt class="docutils literal"><span class="pre">::</span></tt>
	означает что элемент "контроллер" пуст, что означает, что файл
	находится прямо в папке <tt class="docutils literal"><span class="pre">views/</span></tt>.</p>
	<p>Now, let's have a look at a simplified <tt class="docutils literal"><span class="pre">layout.html.twig</span></tt>:</p>
	<div class="highlight-jinja"><div class="highlight"><pre><span class="c">{# src/Acme/DemoBundle/Resources/views/layout.html.twig #}</span><span class="x"></span>
<span class="x">&lt;div class="symfony-content"&gt;</span>
<span class="x">    </span><span class="cp">{%</span> <span class="k">block</span> <span class="nv">content</span> <span class="cp">%}</span><span class="x"></span>
<span class="x">    </span><span class="cp">{%</span> <span class="k">endblock</span> <span class="cp">%}</span><span class="x"></span>
<span class="x">&lt;/div&gt;</span>
	  </pre></div>
	</div>
	<p>The <tt class="docutils literal"><span class="pre">{%</span> <span class="pre">block</span> <span class="pre">%}</span></tt> tags define blocks that child templates can fill in. All
	  the block tag does is to tell the template engine that a child template may
	  override those portions of the template. The <tt class="docutils literal"><span class="pre">hello.html.twig</span></tt> template
	  overrides the <tt class="docutils literal"><span class="pre">content</span></tt> block.</p>
      </div>
      <div class="section" id="using-tags-filters-and-functions">
	<h2>Using Tags, Filters, and Functions<a class="headerlink" href="#using-tags-filters-and-functions" title="Permalink to this headline">¶</a></h2>
	<p>One of the best feature of Twig is its extensibility via tags, filters, and
	  functions. Symfony2 comes bundled with many of these built-in to ease the
	  work of the template designer.</p>
	<div class="section" id="including-other-templates">
	  <h3>Including other Templates<a class="headerlink" href="#including-other-templates" title="Permalink to this headline">¶</a></h3>
	  <p>The best way to share a snippet of code between several distinct templates is
	    to create a new template that can then be included from other templates.</p>
	  <p>Create an <tt class="docutils literal"><span class="pre">embedded.html.twig</span></tt> template:</p>
	  <div class="highlight-jinja"><div class="highlight"><pre><span class="c">{# src/Acme/DemoBundle/Resources/views/Demo/embedded.html.twig #}</span><span class="x"></span>
<span class="x">Hello </span><span class="cp">{{</span> <span class="nv">name</span> <span class="cp">}}</span><span class="x"></span>
	    </pre></div>
	  </div>
	  <p>And change the <tt class="docutils literal"><span class="pre">index.html.twig</span></tt> template to include it:</p>
	  <div class="highlight-jinja"><div class="highlight"><pre><span class="c">{# src/Acme/DemoBundle/Resources/views/Demo/hello.html.twig #}</span><span class="x"></span>
<span class="cp">{%</span> <span class="k">extends</span> <span class="s2">"AcmeDemoBundle::layout.html.twig"</span> <span class="cp">%}</span><span class="x"></span>

<span class="c">{# override the body block from embedded.html.twig #}</span><span class="x"></span>
<span class="cp">{%</span> <span class="k">block</span> <span class="nv">content</span> <span class="cp">%}</span><span class="x"></span>
<span class="x">    </span><span class="cp">{%</span> <span class="k">include</span> <span class="s2">"AcmeDemoBundle:Demo:embedded.html.twig"</span> <span class="cp">%}</span><span class="x"></span>
<span class="cp">{%</span> <span class="k">endblock</span> <span class="cp">%}</span><span class="x"></span>
	    </pre></div>
	  </div>
	</div>
	<div class="section" id="embedding-other-controllers">
	  <h3>Embedding other Controllers<a class="headerlink" href="#embedding-other-controllers" title="Permalink to this headline">¶</a></h3>
	  <p>And what if you want to embed the result of another controller in a template?
	    That's very useful when working with Ajax, or when the embedded template needs
	    some variable not available in the main template.</p>
	  <p>Suppose you've created a <tt class="docutils literal"><span class="pre">fancy</span></tt> action, and you want to include it inside
	    the <tt class="docutils literal"><span class="pre">index</span></tt> template. To do this, use the <tt class="docutils literal"><span class="pre">render</span></tt> tag:</p>
	  <div class="highlight-jinja"><div class="highlight"><pre><span class="c">{# src/Acme/DemoBundle/Resources/views/Demo/index.html.twig #}</span><span class="x"></span>
<span class="cp">{%</span> <span class="k">render</span> <span class="s2">"AcmeDemoBundle:Demo:fancy"</span> <span class="k">with</span> <span class="o">{</span> <span class="s1">'name'</span><span class="o">:</span> <span class="nv">name</span><span class="o">,</span> <span class="s1">'color'</span><span class="o">:</span> <span class="s1">'green'</span> <span class="o">}</span> <span class="cp">%}</span><span class="x"></span>
	    </pre></div>
	  </div>
	  <p>Here, the <tt class="docutils literal"><span class="pre">AcmeDemoBundle:Demo:fancy</span></tt> string refers to the <tt class="docutils literal"><span class="pre">fancy</span></tt> action
	    of the <tt class="docutils literal"><span class="pre">Demo</span></tt> controller. The arguments (<tt class="docutils literal"><span class="pre">name</span></tt> and <tt class="docutils literal"><span class="pre">color</span></tt>) act like
	    simulated request variables (as if the <tt class="docutils literal"><span class="pre">fancyAction</span></tt> were handling a whole
	    new request) and are made available to the controller:</p>
	  <div class="highlight-php"><div class="highlight"><pre><span class="c1">// src/Acme/DemoBundle/Controller/DemoController.php</span>

<span class="k">class</span> <span class="nc">DemoController</span> <span class="k">extends</span> <span class="nx">Controller</span>
<span class="p">{</span>
    <span class="k">public</span> <span class="k">function</span> <span class="nf">fancyAction</span><span class="p">(</span><span class="nv">$name</span><span class="p">,</span> <span class="nv">$color</span><span class="p">)</span>
    <span class="p">{</span>
        <span class="c1">// create some object, based on the $color variable</span>
        <span class="nv">$object</span> <span class="o">=</span> <span class="o">...</span><span class="p">;</span>

        <span class="k">return</span> <span class="nv">$this</span><span class="o">-&gt;</span><span class="na">render</span><span class="p">(</span><span class="s1">'AcmeDemoBundle:Demo:fancy.html.twig'</span><span class="p">,</span> <span class="k">array</span><span class="p">(</span><span class="s1">'name'</span> <span class="o">=&gt;</span> <span class="nv">$name</span><span class="p">,</span> <span class="s1">'object'</span> <span class="o">=&gt;</span> <span class="nv">$object</span><span class="p">));</span>
    <span class="p">}</span>

    <span class="c1">// ...</span>
<span class="p">}</span>
	    </pre></div>
	  </div>
	</div>
	<div class="section" id="creating-links-between-pages">
	  <h3>Creating Links between Pages<a class="headerlink" href="#creating-links-between-pages" title="Permalink to this headline">¶</a></h3>
	  <p>Speaking of web applications, creating links between pages is a must. Instead
	    of hardcoding URLs in templates, the <tt class="docutils literal"><span class="pre">path</span></tt> function knows how to generate
	    URLs based on the routing configuration. That way, all your URLs can be easily
	    updated by just changing the configuration:</p>
	  <div class="highlight-html+jinja"><div class="highlight"><pre><span class="nt">&lt;a</span> <span class="na">href=</span><span class="s">"</span><span class="cp">{{</span> <span class="nv">path</span><span class="o">(</span><span class="s1">'_demo_hello'</span><span class="o">,</span> <span class="o">{</span> <span class="s1">'name'</span><span class="o">:</span> <span class="s1">'Thomas'</span> <span class="o">})</span> <span class="cp">}}</span><span class="s">"</span><span class="nt">&gt;</span>Greet Thomas!<span class="nt">&lt;/a&gt;</span>
	    </pre></div>
	  </div>
	  <p>The <tt class="docutils literal"><span class="pre">path</span></tt> function takes the route name and an array of parameters as
	    arguments. The route name is the main key under which routes are referenced
	    and the parameters are the values of the placeholders defined in the route
	    pattern:</p>
	  <div class="highlight-php"><div class="highlight"><pre><span class="c1">// src/Acme/DemoBundle/Controller/DemoController.php</span>
<span class="k">use</span> <span class="nx">Sensio\Bundle\FrameworkExtraBundle\Configuration\Route</span><span class="p">;</span>
<span class="k">use</span> <span class="nx">Sensio\Bundle\FrameworkExtraBundle\Configuration\Template</span><span class="p">;</span>

<span class="sd">/**</span>
<span class="sd"> * @Route("/hello/{name}", name="_demo_hello")</span>
<span class="sd"> * @Template()</span>
<span class="sd"> */</span>
<span class="k">public</span> <span class="k">function</span> <span class="nf">helloAction</span><span class="p">(</span><span class="nv">$name</span><span class="p">)</span>
<span class="p">{</span>
    <span class="k">return</span> <span class="k">array</span><span class="p">(</span><span class="s1">'name'</span> <span class="o">=&gt;</span> <span class="nv">$name</span><span class="p">);</span>
<span class="p">}</span>
	    </pre></div>
	  </div>
	  <div class="admonition-wrapper">
	    <div class="tip"></div><div class="admonition admonition-tip"><p class="first admonition-title">Tip</p>
	      <p class="last">The <tt class="docutils literal"><span class="pre">url</span></tt> function generates <em>absolute</em> URLs: <tt class="docutils literal"><span class="pre">{{</span> <span class="pre">url('_demo_hello',</span> <span class="pre">{</span>
		  <span class="pre">'name':</span> <span class="pre">'Thomas'</span> <span class="pre">})</span> <span class="pre">}}</span></tt>.</p>
	  </div></div>
	</div>
	<div class="section" id="including-assets-images-javascripts-and-stylesheets">
	  <h3>Including Assets: images, JavaScripts, and stylesheets<a class="headerlink" href="#including-assets-images-javascripts-and-stylesheets" title="Permalink to this headline">¶</a></h3>
	  <p>What would the Internet be without images, JavaScripts, and stylesheets?
	    Symfony2 provides the <tt class="docutils literal"><span class="pre">asset</span></tt> function to deal with them easily:</p>
	  <div class="highlight-jinja"><div class="highlight"><pre><span class="x">&lt;link href="</span><span class="cp">{{</span> <span class="nv">asset</span><span class="o">(</span><span class="s1">'css/blog.css'</span><span class="o">)</span> <span class="cp">}}</span><span class="x">" rel="stylesheet" type="text/css" /&gt;</span>

<span class="x">&lt;img src="</span><span class="cp">{{</span> <span class="nv">asset</span><span class="o">(</span><span class="s1">'images/logo.png'</span><span class="o">)</span> <span class="cp">}}</span><span class="x">" /&gt;</span>
	    </pre></div>
	  </div>
	  <p>The <tt class="docutils literal"><span class="pre">asset</span></tt> function's main purpose is to make your application more portable.
	    Thanks to this function, you can move the application root directory anywhere
	    under your web root directory without changing anything in your template's
	    code.</p>
	</div>
      </div>
      <div class="section" id="escaping-variables">
	<h2>Экранирование переменных<a class="headerlink" href="#escaping-variables" title="Permalink to this headline">¶</a></h2>
	<p>По-умолчанию Twig настроен на автоматическое экранирование всех выводимых переменных.
	Прочтите <a class="reference external" href="http://www.twig-project.org/documentation">документацию</a> чтобы узнать больше о экранировании переменных и расширении Escaper.
      </div>
      <div class="section" id="final-thoughts">
	<h2>Подведение итогов<a class="headerlink" href="#final-thoughts" title="Permalink to this headline">¶</a></h2>
	<p>Twig простой, но очень мощный шаблонизатор. Благодаря макетам(layout), блокам,
	 шаблонам и включению действий легко организовать шаблоны логичным и расширяемым
	 способом.</p>
	<p>Вы работали с Symfony2 только около 20 минут, но вы уже можете делать удивительные
	вещи. Это и есть сила Symfony2. Изучить основы просто и скоро вы узнаете, что под
	этой простотой скрывается очень гибкая архитектура.</p>
	<p>Но я забегаю вперед. Во-первых, вы должны узнать больше о контроллерах, это и
	 есть тема следующей части урока. Готовы к следующим 10 минутам с Symfony2?
	 </p>
      </div>
    </div>


    

  </div>

  <div class="navigation">
    <a accesskey="P" title="The Big Picture" href="<?php l('doc/quick_tour/the_big_picture')?>">
      «&nbsp;Краткий обзор
    </a><span class="separator">|</span>
    <a accesskey="N" title="The Controller" href="<?php l('doc/quick_tour/the_controller')?>">
      Контроллер&nbsp;»
    </a>
  </div>

</div>
