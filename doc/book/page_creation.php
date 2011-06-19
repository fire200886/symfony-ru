<?php include(__DIR__.'/../_doc.php')?>
<div class="column_02">

  <div class="box_title">
    <h1 class="title_01">Создание страниц в Symfony2</h1>
  </div>
  
  

  <div class="box_article doc_page">

    
    
    <div class="section" id="creating-pages-in-symfony2">
      <span id="index-0"></span><h1>Создание страниц в Symfony2<a class="headerlink" href="#creating-pages-in-symfony2" title="Permalink to this headline">¶</a></h1>
      <p>Создание новой страницы в Symfony2 это простой процесс, состоящий из 2 шагов:</p>
      <ul class="simple">
	<li><em>Создание маршрута</em>: Маршрут определяет URI (например <tt class="docutils literal"><span class="pre">/about</span></tt>) для вашей страницы, а также контроллер (PHP функция), который Symfony2 должен выполнить, когда URI входящего запроса совпадет шаблоном маршрута;</li>
	<li><em>Создание контроллера</em>: Контроллер – это PHP функция, которая принимает входящий запрос и трансформирует его в объект <tt class="docutils literal"><span class="pre">Response</span></tt>.</li>
      </ul>
      <p>Нам нравится такой подход, потому что он соответствует тому как работает Web. Каждое взаимодействие в Web инициализируется HTTP запросом. Забота вашего приложения – интерпретировать запрос и вернуть соответствующий ответ. Symfony2 следует этой философии и предлагает вам инструменты и соглашения, для того чтобы ваше приложение оставалось структурированным при росте его сложности.</p>
      <div class="section" id="the-hello-symfony-page">
	<span id="index-1"></span><h2>Страница “Hello Symfony!”<a class="headerlink" href="#the-hello-symfony-page" title="Permalink to this headline">¶</a></h2>
	<p>Давайте начнем с классического приложения “Hello World!”. Когда мы закончим, пользователь будет иметь возможность получить персональное приветствие, перейдя по следующему URL:</p>
	<div class="highlight-text"><div class="highlight"><pre>http://localhost/app_dev.php/hello/Symfony
	  </pre></div>
	</div>
	<p>Вы также сможете заменить <tt class="docutils literal"><span class="pre">Symfony</span></tt> на другое имя и получить новое приветствие. Для создания этой страницы мы
пройдем простой путь из двух шагов.</p>
	<div class="admonition-wrapper">
	  <div class="note"></div><div class="admonition admonition-note"><p class="first admonition-title">Note</p>
	    <p class="last">Данное руководство подразумевает, что вы уже скачали Symfony2 и настроили ваш вебсервер. URL, указанный выше, подразумевает, что <tt class="docutils literal"><span class="pre">localhost</span></tt> указывает на <tt class="docutils literal"><span class="pre">web</span></tt>-директорию вашего нового Symfony2 проекта. Если же вы ещё не выполнили этих шагов, рекомендуется их выполнить, прежде чем вы продолжите читать.
	      Для подробной информации прочтите <a class="reference internal" href="installation.html"><em>Установка Symfony2</em></a>.</p>
	</div></div>
	<div class="section" id="create-the-bundle">
	  <h3>Создание пакета (bundle)<a class="headerlink" href="#create-the-bundle" title="Permalink to this headline">¶</a></h3>
	  <p>Прежде чем начать, вам необходимо создать пакет (<em>bundle</em>). В Symfony2 пакет напоминает plugin, за исключением того, что весь код вашего приложения будет расположен внутри такого пакета.</p>
	  <p>Вообще говоря, пакет – это не более чем директория (соответствующая тем не менее пространству имен PHP), которая содержит все что относится к какой-то специфической функции (см. <a class="reference internal" href="#page-creation-bundles"><em>Система пакетов</em></a>).
	    Для создания пакета с именем <tt class="docutils literal"><span class="pre">AcmeHelloBundle</span></tt> (демо-пакет, который мы создадим в ходе прочтения данной статьи), необходимо выполнить следующую команду (из корня проекта):</p>
	  <div class="highlight-text"><div class="highlight"><pre>php app/console init:bundle Acme/HelloBundle src
	    </pre></div>
	  </div>
	  <p>Далее, нам необходимо убедиться, что пространство имен <tt class="docutils literal"><span class="pre">Acme</span></tt> загружено – для этого нам надо добавить следующий код в файл <tt class="docutils literal"><span class="pre">app/autoload.php</span></tt> (см. <a class="reference internal" href="#autoloading-introduction-sidebar"><em>Автозагрузка</em></a>):</p>
	  <div class="highlight-php"><div class="highlight"><pre><span class="nv">$loader</span><span class="o">-&gt;</span><span class="na">registerNamespaces</span><span class="p">(</span><span class="k">array</span><span class="p">(</span>
    <span class="s1">'Acme'</span> <span class="o">=&gt;</span> <span class="nx">__DIR__</span><span class="o">.</span><span class="s1">'/../src'</span><span class="p">,</span>
    <span class="c1">// ...</span>
<span class="p">));</span>
	    </pre></div>
	  </div>
	  <p>Наконец, инициализируем пакет, добавляя его в метод <tt class="docutils literal"><span class="pre">registerBundles</span></tt> класса <tt class="docutils literal"><span class="pre">AppKernel</span></tt>:</p>
	  <div class="highlight-php"><div class="highlight"><pre><span class="c1">// app/AppKernel.php</span>
<span class="k">public</span> <span class="k">function</span> <span class="nf">registerBundles</span><span class="p">()</span>
<span class="p">{</span>
    <span class="nv">$bundles</span> <span class="o">=</span> <span class="k">array</span><span class="p">(</span>
        <span class="c1">// ...</span>
        <span class="k">new</span> <span class="nx">Acme\HelloBundle\AcmeHelloBundle</span><span class="p">(),</span>
    <span class="p">);</span>

    <span class="c1">// ...</span>

    <span class="k">return</span> <span class="nv">$bundles</span><span class="p">;</span>
<span class="p">}</span>
	    </pre></div>
	  </div>
	  <p>Теперь, когда мы создали и подключили пакет, мы можем начать создание нашего приложения в нём.</p>
	</div>
	<div class="section" id="create-the-route">
	  <h3>Создание маршрута<a class="headerlink" href="#create-the-route" title="Permalink to this headline">¶</a></h3>
	  <p>По умолчанию, конфигурационный файл маршрутизатора в приложении Symfony2, располагается в <tt class="docutils literal"><span class="pre">app/config/routing.yml</span></tt>. Для конфигурирования маршрутизатора, а также любых прочих конфигураций Symfony2, вы можете также использовать XML или PHP формат:</p>
	  <div class="configuration-block jsactive clearfix">
	    <ul class="simple" style="height: 184px; ">
	      <li class="selected"><em><a href="#">YAML</a></em><div class="highlight-yaml" style="width: 690px; display: block; "><div class="highlight"><pre><span class="c1"># app/config/routing.yml</span>
<span class="l-Scalar-Plain">homepage</span><span class="p-Indicator">:</span>
    <span class="l-Scalar-Plain">pattern</span><span class="p-Indicator">:</span>  <span class="l-Scalar-Plain">/</span>
    <span class="l-Scalar-Plain">defaults</span><span class="p-Indicator">:</span> <span class="p-Indicator">{</span> <span class="nv">_controller</span><span class="p-Indicator">:</span> <span class="nv">FrameworkBundle</span><span class="p-Indicator">:</span><span class="nv">Default</span><span class="p-Indicator">:</span><span class="nv">index</span> <span class="p-Indicator">}</span>

<span class="l-Scalar-Plain">hello</span><span class="p-Indicator">:</span>
    <span class="l-Scalar-Plain">resource</span><span class="p-Indicator">:</span> <span class="s">"@AcmeHelloBundle/Resources/config/routing.yml"</span>
		  </pre></div>
		</div>
	      </li>
	      <li><em><a href="#">XML</a></em><div class="highlight-xml" style="display: none; width: 690px; "><div class="highlight"><pre><span class="c">&lt;!-- app/config/routing.xml --&gt;</span>
<span class="cp">&lt;?xml version="1.0" encoding="UTF-8" ?&gt;</span>

<span class="nt">&lt;routes</span> <span class="na">xmlns=</span><span class="s">"http://symfony.com/schema/routing"</span>
    <span class="na">xmlns:xsi=</span><span class="s">"http://www.w3.org/2001/XMLSchema-instance"</span>
    <span class="na">xsi:schemaLocation=</span><span class="s">"http://symfony.com/schema/routing http://symfony.com/schema/routing/routing-1.0.xsd"</span><span class="nt">&gt;</span>

    <span class="nt">&lt;route</span> <span class="na">id=</span><span class="s">"homepage"</span> <span class="na">pattern=</span><span class="s">"/"</span><span class="nt">&gt;</span>
        <span class="nt">&lt;default</span> <span class="na">key=</span><span class="s">"_controller"</span><span class="nt">&gt;</span>FrameworkBundle:Default:index<span class="nt">&lt;/default&gt;</span>
    <span class="nt">&lt;/route&gt;</span>

    <span class="nt">&lt;import</span> <span class="na">resource=</span><span class="s">"@AcmeHelloBundle/Resources/config/routing.xml"</span> <span class="nt">/&gt;</span>
<span class="nt">&lt;/routes&gt;</span>
		  </pre></div>
		</div>
	      </li>
	      <li><em><a href="#">PHP</a></em><div class="highlight-php" style="display: none; width: 690px; "><div class="highlight"><pre><span class="c1">// app/config/routing.php</span>
<span class="k">use</span> <span class="nx">Symfony\Component\Routing\RouteCollection</span><span class="p">;</span>
<span class="k">use</span> <span class="nx">Symfony\Component\Routing\Route</span><span class="p">;</span>

<span class="nv">$collection</span> <span class="o">=</span> <span class="k">new</span> <span class="nx">RouteCollection</span><span class="p">();</span>
<span class="nv">$collection</span><span class="o">-&gt;</span><span class="na">add</span><span class="p">(</span><span class="s1">'homepage'</span><span class="p">,</span> <span class="k">new</span> <span class="nx">Route</span><span class="p">(</span><span class="s1">'/'</span><span class="p">,</span> <span class="k">array</span><span class="p">(</span>
    <span class="s1">'_controller'</span> <span class="o">=&gt;</span> <span class="s1">'FrameworkBundle:Default:index'</span><span class="p">,</span>
<span class="p">)));</span>
<span class="nv">$collection</span><span class="o">-&gt;</span><span class="na">addCollection</span><span class="p">(</span><span class="nv">$loader</span><span class="o">-&gt;</span><span class="na">import</span><span class="p">(</span><span class="s2">"@AcmeHelloBundle/Resources/config/routing.php"</span><span class="p">));</span>

<span class="k">return</span> <span class="nv">$collection</span><span class="p">;</span>
		  </pre></div>
		</div>
	      </li>
	    </ul>
	  </div>
	  <p>Первые строки конфигурации определяют, какой код будет вызван для запроса "<tt class="docutils literal"><span class="pre">/</span></tt>" (homepage) и служат примером конфигурации маршрута. Последняя часть более интересна – в ней импортируется другой конфигурационный файл маршрутизатора, который находится внутри <tt class="docutils literal"><span class="pre">AcmeHelloBundle</span></tt>:</p>
	  <div class="configuration-block jsactive clearfix">
	    <ul class="simple" style="height: 130px; ">
	      <li class="selected"><em><a href="#">YAML</a></em><div class="highlight-yaml" style="width: 690px; display: block; "><div class="highlight"><pre><span class="c1"># src/Acme/HelloBundle/Resources/config/routing.yml</span>
<span class="l-Scalar-Plain">hello</span><span class="p-Indicator">:</span>
    <span class="l-Scalar-Plain">pattern</span><span class="p-Indicator">:</span>  <span class="l-Scalar-Plain">/hello/{name}</span>
    <span class="l-Scalar-Plain">defaults</span><span class="p-Indicator">:</span> <span class="p-Indicator">{</span> <span class="nv">_controller</span><span class="p-Indicator">:</span> <span class="nv">AcmeHelloBundle</span><span class="p-Indicator">:</span><span class="nv">Hello</span><span class="p-Indicator">:</span><span class="nv">index</span> <span class="p-Indicator">}</span>
		  </pre></div>
		</div>
	      </li>
	      <li><em><a href="#">XML</a></em><div class="highlight-xml" style="display: none; width: 690px; "><div class="highlight"><pre><span class="c">&lt;!-- src/Acme/HelloBundle/Resources/config/routing.xml --&gt;</span>
<span class="cp">&lt;?xml version="1.0" encoding="UTF-8" ?&gt;</span>

<span class="nt">&lt;routes</span> <span class="na">xmlns=</span><span class="s">"http://symfony.com/schema/routing"</span>
    <span class="na">xmlns:xsi=</span><span class="s">"http://www.w3.org/2001/XMLSchema-instance"</span>
    <span class="na">xsi:schemaLocation=</span><span class="s">"http://symfony.com/schema/routing http://symfony.com/schema/routing/routing-1.0.xsd"</span><span class="nt">&gt;</span>

    <span class="nt">&lt;route</span> <span class="na">id=</span><span class="s">"hello"</span> <span class="na">pattern=</span><span class="s">"/hello/{name}"</span><span class="nt">&gt;</span>
        <span class="nt">&lt;default</span> <span class="na">key=</span><span class="s">"_controller"</span><span class="nt">&gt;</span>AcmeHelloBundle:Hello:index<span class="nt">&lt;/default&gt;</span>
    <span class="nt">&lt;/route&gt;</span>
<span class="nt">&lt;/routes&gt;</span>
		  </pre></div>
		</div>
	      </li>
	      <li><em><a href="#">PHP</a></em><div class="highlight-php" style="display: none; width: 690px; "><div class="highlight"><pre><span class="c1">// src/Acme/HelloBundle/Resources/config/routing.php</span>
<span class="k">use</span> <span class="nx">Symfony\Component\Routing\RouteCollection</span><span class="p">;</span>
<span class="k">use</span> <span class="nx">Symfony\Component\Routing\Route</span><span class="p">;</span>

<span class="nv">$collection</span> <span class="o">=</span> <span class="k">new</span> <span class="nx">RouteCollection</span><span class="p">();</span>
<span class="nv">$collection</span><span class="o">-&gt;</span><span class="na">add</span><span class="p">(</span><span class="s1">'hello'</span><span class="p">,</span> <span class="k">new</span> <span class="nx">Route</span><span class="p">(</span><span class="s1">'/hello/{name}'</span><span class="p">,</span> <span class="k">array</span><span class="p">(</span>
    <span class="s1">'_controller'</span> <span class="o">=&gt;</span> <span class="s1">'AcmeHelloBundle:Hello:index'</span><span class="p">,</span>
<span class="p">)));</span>

<span class="k">return</span> <span class="nv">$collection</span><span class="p">;</span>
		  </pre></div>
		</div>
	      </li>
	    </ul>
	  </div>
	  <p>Маршрут состоит из двух основных частей: <tt class="docutils literal"><span class="pre">шаблон</span></tt>, с которым сравнивается URI, а также массив <tt class="docutils literal"><span class="pre">параметров по умолчанию (defaults)</span></tt> в котором указывается контроллер, который необходимо выполнить. Синтаксис указателя места заполнения (placeholder) в шаблоне 
	    (<tt class="docutils literal"><span class="pre">{name}</span></tt>) – это групповой символ (wildcard). Он означает, что URI <tt class="docutils literal"><span class="pre">/hello/Ryan</span></tt>, <tt class="docutils literal"><span class="pre">/hello/Fabien</span></tt>,
	    а также прочие, походие на них, будут соответствовать этому маршруту. Параметр, определённый указателем <tt class="docutils literal"><span class="pre">{name}</span></tt> также будет передан в наш контроллер, так что мы сможем использовать его, чтобы поприветствовать пользователя.</p>
	  <div class="admonition-wrapper">
	    <div class="note"></div><div class="admonition admonition-note"><p class="first admonition-title">Note</p>
	      <p class="last">Система маршрутизации имеет еще множество замечательных функций для создания гибких и функциональных структур URI в нашем приложении. За дополнительной информацией вы можете обратиться к главе <a class="reference internal" href="routing.html"><em>Маршрутизация</em></a>.</p>
	  </div></div>
	</div>
	<div class="section" id="create-the-controller">
	  <h3>Создание Контроллера<a class="headerlink" href="#create-the-controller" title="Permalink to this headline">¶</a></h3>
	  <p>Когда URI вида <tt class="docutils literal"><span class="pre">/hello/Ryan</span></tt> обнаруживается приложением в запросе, маршрут <tt class="docutils literal"><span class="pre">hello</span></tt>
	    сработает и будет вызван контроллер <tt class="docutils literal"><span class="pre">AcmeHelloBundle:Hello:index</span></tt> Следующим нашим шагом будет создание этого контроллера.</p>
	  <p>В действительности, контроллер – это не что иное, как метод PHP класса, который мы создаем, а Symfony выполняет. Это то место, где приложение, используя информацию из запроса, создает запрошенный ресурс. За исключением некоторых особых случаев, результатом работы контроллера всегда является объект Symfony2 <tt class="docutils literal"><span class="pre">Response</span></tt>:</p>
	  <div class="highlight-php"><div class="highlight"><pre><span class="c1">// src/Acme/HelloBundle/Controller/HelloController.php</span>

<span class="k">namespace</span> <span class="nx">Acme\HelloBundle\Controller</span><span class="p">;</span>
<span class="k">use</span> <span class="nx">Symfony\Component\HttpFoundation\Response</span><span class="p">;</span>

<span class="k">class</span> <span class="nc">HelloController</span>
<span class="p">{</span>
    <span class="k">public</span> <span class="k">function</span> <span class="nf">indexAction</span><span class="p">(</span><span class="nv">$name</span><span class="p">)</span>
    <span class="p">{</span>
        <span class="k">return</span> <span class="k">new</span> <span class="nx">Response</span><span class="p">(</span><span class="s1">'&lt;html&gt;&lt;body&gt;Hello '</span><span class="o">.</span><span class="nv">$name</span><span class="o">.</span><span class="s1">'!&lt;/body&gt;&lt;/html&gt;'</span><span class="p">);</span>
    <span class="p">}</span>
<span class="p">}</span>
	    </pre></div>
	  </div>
	  <p>Этот контроллер предельно прост: он создает новый объект <tt class="docutils literal"><span class="pre">Response</span></tt> чьим первым аргументом является контент, который будет использован для создания ответа (в нашем случае это маленькая HTML-страница, код которой мы указали прямо в контроллере).</p>
	  <p>Примите мои поздравления! После создания маршрута и контроллера, вы уже имеете полноценную страницу! Если вы все настроили корректно, ваше приложение должно поприветствовать вас:</p>
	  <div class="highlight-php"><div class="highlight"><pre><span class="nx">http</span><span class="o">://</span><span class="nx">localhost</span><span class="o">/</span><span class="nx">app_dev</span><span class="o">.</span><span class="nx">php</span><span class="o">/</span><span class="nx">hello</span><span class="o">/</span><span class="nx">Ryan</span>
	    </pre></div>
	  </div>
	  <p>Опциональным (но как правило востребованным) третьим шагом является создание шаблона.</p>
	  <div class="admonition-wrapper">
	    <div class="note"></div><div class="admonition admonition-note"><p class="first admonition-title">Note</p>
	      <p class="last">Контроллер – это главная точка входа для вашего кода и ключевой ингридиет при создании страниц. Больше информации о контроллерах вы можете найти в главе
		<a class="reference internal" href="controller.html"><em>Контрллеры</em></a>.</p>
	  </div></div>
	</div>
	<div class="section" id="create-the-template">
	  <h3>Создание шаблона<a class="headerlink" href="#create-the-template" title="Permalink to this headline">¶</a></h3>
	  <p>Шаблоны позволяют нам вынести разметку страниц (HTML код как вравило) в отдельный файл и повторно использовать различные части шаблона страницы. Вместо того чтобы писать код внутри контроллера, воспользуемся шаблоном:</p>
	  <div class="highlight-php"><table class="highlighttable"><tbody><tr><td class="linenos"><div class="linenodiv"><pre> 1
 2
 3
 4
 5
 6
 7
 8
 9
10
11
12
13
14
			15</pre></div></td><td class="code"><div class="highlight"><pre><span class="c1">// src/Acme/HelloBundle/Controller/HelloController.php</span>
<span class="k">namespace</span> <span class="nx">Acme\HelloBundle\Controller</span><span class="p">;</span>

<span class="k">use</span> <span class="nx">Symfony\Bundle\FrameworkBundle\Controller\Controller</span><span class="p">;</span>

<span class="k">class</span> <span class="nc">HelloController</span> <span class="k">extends</span> <span class="nx">Controller</span>
<span class="p">{</span>
    <span class="k">public</span> <span class="k">function</span> <span class="nf">indexAction</span><span class="p">(</span><span class="nv">$name</span><span class="p">)</span>
    <span class="p">{</span>
        <span class="k">return</span> <span class="nv">$this</span><span class="o">-&gt;</span><span class="na">render</span><span class="p">(</span><span class="s1">'AcmeHelloBundle:Hello:index.html.twig'</span><span class="p">,</span> <span class="k">array</span><span class="p">(</span><span class="s1">'name'</span> <span class="o">=&gt;</span> <span class="nv">$name</span><span class="p">));</span>

        <span class="c1">// render a PHP template instead</span>
        <span class="c1">// return $this-&gt;render('AcmeHelloBundle:Hello:index.html.php', array('name' =&gt; $name));</span>
    <span class="p">}</span>
<span class="p">}</span>
		    </pre></div>
	  </td></tr></tbody></table></div>
	  <div class="admonition-wrapper">
	    <div class="note"></div><div class="admonition admonition-note"><p class="first admonition-title">Note</p>
	      <p class="last">Для того, чтобы использовать метод <tt class="docutils literal"><span class="pre">render()</span></tt> необходимо отнаследоваться от класса
		<tt class="docutils literal"><span class="pre">Symfony\Bundle\FrameworkBundle\Controller\Controller</span></tt> (API: <tt class="docutils literal"><a class="reference external" href="http://api.symfony.com/2.0/Symfony/Bundle/FrameworkBundle/Controller/Controller.html" title="Symfony\Bundle\FrameworkBundle\Controller\Controller"><span class="pre">Controller</span></a></tt>),
		который добавляет несколько методов для быстрого вызова для часто употребляемых функций в контроллере. В примере выше это сделано добавлением <tt class="docutils literal"><span class="pre">use</span></tt> на линии 4
		и расширением класса <tt class="docutils literal"><span class="pre">Controller</span></tt> на линии 6.</p>
	  </div></div>
	  <p>Метод <tt class="docutils literal"><span class="pre">render()</span></tt> создает объект <tt class="docutils literal"><span class="pre">Response</span></tt>, заполненный содержанием обработанного (рендереного) шаблона. Как и любой другой контроллер, вы в конце концов вернете объект <tt class="docutils literal"><span class="pre">Response</span></tt>.</p>
	  <p>Обратите внимание, что есть две различные возможности рендеринга шаблонов. Symfony2 по-умолчанию, поддерживает 2 языка шаблонов: классические PHP-шаблоны и простой, но мощный язык шаблонов <a class="reference external" href="http://www.twig-project.org">Twig</a>. Но не пугайтесь, вы свободны в выборе того или иного из них, кроме того вы можете использовать оба в рамках одного проекта.</p>
	  <p>Контроллер отображает шаблон <tt class="docutils literal"><span class="pre">AcmeHelloBundle:Hello:index.html.twig</span></tt>, который использует следующие соглашения:</p>
	  <p><em>BundleName</em>:<em>ControllerName</em>:<em>TemplateName</em></p>
	  <p>Таким образом, <tt class="docutils literal"><span class="pre">AcmeHelloBundle</span></tt> – это имя пакета, <tt class="docutils literal"><span class="pre">Hello</span></tt> – это контроллер и <tt class="docutils literal"><span class="pre">index.html.twig</span></tt> это шаблон:</p>
	  <div class="configuration-block jsactive clearfix">
	    <ul class="simple" style="height: 168px; ">
	      <li class="selected"><em><a href="#">Twig</a></em><div class="highlight-jinja" style="width: 690px; display: block; "><table class="highlighttable"><tbody><tr><td class="linenos"><div class="linenodiv"><pre>1
2
3
4
5
			      6</pre></div></td><td class="code"><div class="highlight"><pre><span class="x"> </span><span class="c">{# src/Acme/HelloBundle/Resources/views/Hello/index.html.twig #}</span><span class="x"></span>
<span class="x"> </span><span class="cp">{%</span> <span class="k">extends</span> <span class="s1">'::layout.html.twig'</span> <span class="cp">%}</span><span class="x"></span>

<span class="x"> </span><span class="cp">{%</span> <span class="k">block</span> <span class="nv">body</span> <span class="cp">%}</span><span class="x"></span>
<span class="x">     Hello </span><span class="cp">{{</span> <span class="nv">name</span> <span class="cp">}}</span><span class="x">!</span>
<span class="x"> </span><span class="cp">{%</span> <span class="k">endblock</span> <span class="cp">%}</span><span class="x"></span>
			  </pre></div>
		</td></tr></tbody></table></div>
	      </li>
	      <li><em><a href="#">PHP</a></em><div class="highlight-php" style="display: none; width: 690px; "><div class="highlight"><pre><span class="o">&lt;!--</span> <span class="nx">src</span><span class="o">/</span><span class="nx">Acme</span><span class="o">/</span><span class="nx">HelloBundle</span><span class="o">/</span><span class="nx">Resources</span><span class="o">/</span><span class="nx">views</span><span class="o">/</span><span class="nx">Hello</span><span class="o">/</span><span class="nx">index</span><span class="o">.</span><span class="nx">html</span><span class="o">.</span><span class="nx">php</span> <span class="o">--&gt;</span>
<span class="o">&lt;?</span><span class="nx">php</span> <span class="nv">$view</span><span class="o">-&gt;</span><span class="na">extend</span><span class="p">(</span><span class="s1">'::layout.html.php'</span><span class="p">)</span> <span class="cp">?&gt;</span><span class="x"></span>

<span class="x">Hello </span><span class="cp">&lt;?php</span> <span class="k">echo</span> <span class="nv">$view</span><span class="o">-&gt;</span><span class="na">escape</span><span class="p">(</span><span class="nv">$name</span><span class="p">)</span> <span class="cp">?&gt;</span><span class="x">!</span>
		  </pre></div>
		</div>
	      </li>
	    </ul>
	  </div>
	  <p>Давайте рассмотрим подробнее шаблон Twig:</p>
	  <ul class="simple">
	    <li><em>Строка 2</em>: Токен <tt class="docutils literal"><span class="pre">extends</span></tt> определяет родительский шаблон. Таким образом сам шаблон однозначным
образом определяет родителя (layout) внутрь которого он будет помещен.</li>
	    <li><em>Строка 4</em>: Токен <tt class="docutils literal"><span class="pre">block</span></tt> означает, что все внутри него будет помещено в блок с именем <tt class="docutils literal"><span class="pre">body</span></tt>. Как мы увидим ниже, это уже обязанность родительского шаблона (<tt class="docutils literal"><span class="pre">layout.html.twig</span></tt>) – полностью отобразить блок <tt class="docutils literal"><span class="pre">body</span></tt>.</li>
	  </ul>
	  <p>Родительский шаблон, <tt class="docutils literal"><span class="pre">::layout.html.twig</span></tt>, не включает в себя ни имени пакета, ни контроллера (отсюда и двойное двоеточие в начале имени (<tt class="docutils literal"><span class="pre">::</span></tt>)). Это означает что шаблон располагается вне пакета в директории <tt class="docutils literal"><span class="pre">app</span></tt>:</p>
	  <div class="configuration-block jsactive clearfix">
	    <ul class="simple" style="height: 256px; ">
	      <li class="selected"><em><a href="#">Twig</a></em><div class="highlight-html+jinja" style="width: 690px; display: block; "><div class="highlight"><pre><span class="c">{# app/Resources/views/layout.html.twig #}</span>
<span class="cp">&lt;!DOCTYPE html&gt;</span>
<span class="nt">&lt;html&gt;</span>
    <span class="nt">&lt;head&gt;</span>
        <span class="nt">&lt;meta</span> <span class="na">http-equiv=</span><span class="s">"Content-Type"</span> <span class="na">content=</span><span class="s">"text/html; charset=utf-8"</span> <span class="nt">/&gt;</span>
        <span class="nt">&lt;title&gt;</span><span class="cp">{%</span> <span class="k">block</span> <span class="nv">title</span> <span class="cp">%}</span>Hello Application<span class="cp">{%</span> <span class="k">endblock</span> <span class="cp">%}</span><span class="nt">&lt;/title&gt;</span>
    <span class="nt">&lt;/head&gt;</span>
    <span class="nt">&lt;body&gt;</span>
        <span class="cp">{%</span> <span class="k">block</span> <span class="nv">body</span> <span class="cp">%}{%</span> <span class="k">endblock</span> <span class="cp">%}</span>
    <span class="nt">&lt;/body&gt;</span>
<span class="nt">&lt;/html&gt;</span>
		  </pre></div>
		</div>
	      </li>
	      <li><em><a href="#">PHP</a></em><div class="highlight-php" style="display: none; width: 690px; "><div class="highlight"><pre><span class="o">&lt;!--</span> <span class="nx">app</span><span class="o">/</span><span class="nx">Resources</span><span class="o">/</span><span class="nx">views</span><span class="o">/</span><span class="nx">layout</span><span class="o">.</span><span class="nx">html</span><span class="o">.</span><span class="nx">php</span> <span class="o">--&gt;</span>
<span class="o">&lt;!</span><span class="nx">DOCTYPE</span> <span class="nx">html</span><span class="o">&gt;</span>
<span class="o">&lt;</span><span class="nx">html</span><span class="o">&gt;</span>
    <span class="o">&lt;</span><span class="nx">head</span><span class="o">&gt;</span>
        <span class="o">&lt;</span><span class="nx">meta</span> <span class="nx">http</span><span class="o">-</span><span class="nx">equiv</span><span class="o">=</span><span class="s2">"Content-Type"</span> <span class="nx">content</span><span class="o">=</span><span class="s2">"text/html; charset=utf-8"</span> <span class="o">/&gt;</span>
        <span class="o">&lt;</span><span class="nx">title</span><span class="o">&gt;&lt;?</span><span class="nx">php</span> <span class="nv">$view</span><span class="p">[</span><span class="s1">'slots'</span><span class="p">]</span><span class="o">-&gt;</span><span class="na">output</span><span class="p">(</span><span class="s1">'title'</span><span class="p">,</span> <span class="s1">'Hello Application'</span><span class="p">)</span> <span class="cp">?&gt;</span><span class="x">&lt;/title&gt;</span>
<span class="x">    &lt;/head&gt;</span>
<span class="x">    &lt;body&gt;</span>
<span class="x">        </span><span class="cp">&lt;?php</span> <span class="nv">$view</span><span class="p">[</span><span class="s1">'slots'</span><span class="p">]</span><span class="o">-&gt;</span><span class="na">output</span><span class="p">(</span><span class="s1">'_content'</span><span class="p">)</span> <span class="cp">?&gt;</span><span class="x"></span>
<span class="x">    &lt;/body&gt;</span>
<span class="x">&lt;/html&gt;</span>
		  </pre></div>
		</div>
	      </li>
	    </ul>
	  </div>
	  <p>Базовый шаблон определяет HTML разметку блока <tt class="docutils literal"><span class="pre">body</span></tt>, который мы определили в шаблоне <tt class="docutils literal"><span class="pre">index.html.twig</span></tt>. Он также отображает блок <tt class="docutils literal"><span class="pre">title</span></tt>, который мы также можем определить в <tt class="docutils literal"><span class="pre">index.html.twig</span></tt>Так как мы не определили блок <tt class="docutils literal"><span class="pre">title</span></tt> в дочернем шаблоне, он примет значение по умолчанию – “Hello Application”.</p>
	  <p>Шаблоны являются мощным инструментом по организации и отображению контента ваших страниц – HTML разметки, CSS стилей, а также всего прочего, что может потребоваться вернуть контроллеру. Но шаблонизатор – это просто средство для достижения цели. А цель состоит в том, чтобы каждый контроллер возвращал объект <tt class="docutils literal"><span class="pre">Response</span></tt>. Таким образом, шаблоны мощный, но опциональный инструмент для создания контента для объекта <tt class="docutils literal"><span class="pre">Response</span></tt>.</p>
	</div>
      </div>
      <div class="section" id="the-directory-structure">
	<span id="index-2"></span><h2>Структура директорий<a class="headerlink" href="#the-directory-structure" title="Permalink to this headline">¶</a></h2>
	<p>Мы прочитали всего лишь после нескольких коротких секций, а вы уже уяснили философию создания и отображения страниц в Symfony2. Поэтому без лишних слов мы приступим к изучению того, как организованы и структурированы проекты Symfony2. К концу этой секции вы будете знать где найти и куда поместить различные типы файлов. И более того, будет понимать – почему!</p>
	<p>Изначально созданный очень гибким, по умолчанию каждое Symfony <a class="reference internal" href="../glossary.html#term-application"><em class="xref std std-term">приложение</em></a> имеет одну и ту же базовую (и рекомендуемую) структуру директорий:</p>
	<ul class="simple">
	  <li><tt class="docutils literal"><span class="pre">app/</span></tt>: Эта директория содержит настройки приложения;</li>
	  <li><tt class="docutils literal"><span class="pre">src/</span></tt>: Весь PHP код проекта находится в этой директории;</li>
	  <li><tt class="docutils literal"><span class="pre">vendor/</span></tt>: Здесь размещаются сторонние библиотеки;</li>
	  <li><tt class="docutils literal"><span class="pre">web/</span></tt>: Это корневая директория, видимая web-серверу и содержащая доступные пользователям файлы;</li>
	</ul>
	<div class="section" id="the-web-directory">
	  <h3>Директория Web<a class="headerlink" href="#the-web-directory" title="Permalink to this headline">¶</a></h3>
	  <p>Web-директория – это дом для всех публично-доступных статических файлов, таких как изображения, таблицы стилей и JavaScript файлы. Тут также располагаются все
	    <a class="reference internal" href="../glossary.html#term-front-controller"><em class="xref std std-term">фронт-контроллеры</em></a>:</p>
	  <div class="highlight-php"><div class="highlight"><pre><span class="c1">// web/app.php</span>
<span class="k">require_once</span> <span class="nx">__DIR__</span><span class="o">.</span><span class="s1">'/../app/bootstrap.php'</span><span class="p">;</span>
<span class="k">require_once</span> <span class="nx">__DIR__</span><span class="o">.</span><span class="s1">'/../app/AppKernel.php'</span><span class="p">;</span>

<span class="k">use</span> <span class="nx">Symfony\Component\HttpFoundation\Request</span><span class="p">;</span>

<span class="nv">$kernel</span> <span class="o">=</span> <span class="k">new</span> <span class="nx">AppKernel</span><span class="p">(</span><span class="s1">'prod'</span><span class="p">,</span> <span class="k">false</span><span class="p">);</span>
<span class="nv">$kernel</span><span class="o">-&gt;</span><span class="na">handle</span><span class="p">(</span><span class="nx">Request</span><span class="o">::</span><span class="na">createFromGlobals</span><span class="p">())</span><span class="o">-&gt;</span><span class="na">send</span><span class="p">();</span>
	    </pre></div>
	  </div>
	  <p>Файл фронт-контроллера (в примере выше – <tt class="docutils literal"><span class="pre">app.php</span></tt>)- это PHP файл, который выполняется, когда используется Symfony2 приложение и в его обязанности входит использование Kernel-класса, <tt class="docutils literal"><span class="pre">AppKernel</span></tt>, для запуска приложения.</p>
	  <div class="admonition-wrapper">
	    <div class="tip"></div><div class="admonition admonition-tip"><p class="first admonition-title">Tip</p>
	      <p>Наличие фронт-контроллера означает возможность использования более гибких URL, отличных от тех, что используются в типичном “плоском” PHP-приложении. Когда используется фронт-контроллер, URL формируется следующим образом:</p>
	      <blockquote>
		<div><a class="reference external" href="http://localhost/app.php/hello/Ryan">http://localhost/app.php/hello/Ryan</a></div></blockquote>
	      <p>Фронт-контроллер <tt class="docutils literal"><span class="pre">app.php</span></tt> выполняется и URI <tt class="docutils literal"><span class="pre">/hello/Ryan</span></tt>
		направляется внутри приложения с использованием конфигурации маршрутизатора.  С использованием правил
		<tt class="docutils literal"><span class="pre">mod_rewrite</span></tt> для Apache вы можете перенаправлять все запросы (на физически не существующие URI) на <tt class="docutils literal"><span class="pre">app.php</span></tt>, чтобы явно не указывать его в URL:</p>
	      <div class="last highlight-php"><div class="highlight"><pre><span class="nx">http</span><span class="o">://</span><span class="nx">localhost</span><span class="o">/</span><span class="nx">hello</span><span class="o">/</span><span class="nx">Ryan</span>
		</pre></div>
	      </div>
	  </div></div>
	  <p>Хотя фронт-контроллеры имеют важное значение при обработке каждого запроса,вам нечасто придется модифицировать их или вообще вспоминать об их существовании. Мы еще вкратце упомянем о них в разделе, где говорится об <a class="reference internal" href="#environments">Окружениях</a>.</p>
	</div>
	<div class="section" id="the-application-app-directory">
	  <h3>Директория приложения (<tt class="docutils literal"><span class="pre">app</span></tt>)<a class="headerlink" href="#the-application-app-directory" title="Permalink to this headline">¶</a></h3>
	  <p>Как вы уже видели во фронт-контроллере, класс <tt class="docutils literal"><span class="pre">AppKernel</span></tt> – это точка входа приложения и он отвечает за его конфигурацию. Как таковой, этот класс расположен в директории <tt class="docutils literal"><span class="pre">app/</span></tt>.</p>
	  <p>Этот класс должен реализовывать три метода, которые определяются все, что Symfony необходимо знать о вашем приложении. Вам даже не нужно беспокоиться о реализации этих методов, когда начинаете работу – они уже реализованы с кодом по-умолчанию.</p>
	  <ul class="simple">
	    <li><tt class="docutils literal"><span class="pre">registerBundles()</span></tt>: Возвращает массив всех пакетов, необходимых для запуска приложения (см. секцию see <a class="reference internal" href="#the-bundle-system">Пакетная система</a>);</li>
	    <li><tt class="docutils literal"><span class="pre">registerContainerConfiguration()</span></tt>: Загружает главный конфигурационный файл (см. секцию <a class="reference internal" href="#application-configuration">Конфигурация приложения</a>);</li>
	    <li><tt class="docutils literal"><span class="pre">registerRootDir()</span></tt>: Возвращает корневую директорию приложения (по умолчанию <tt class="docutils literal"><span class="pre">app/</span></tt>).</li>
	  </ul>
	  <p>Изо дня в день вы будете использовать директорию <tt class="docutils literal"><span class="pre">app/</span></tt> в основном для того, чтобы модифицировать конфигурацию и настройки маршрутизатора в директории <tt class="docutils literal"><span class="pre">app/config/</span></tt> (см.
	    <a class="reference internal" href="#application-configuration">Конфигурация приложения</a>). Также в app/ содержится кеш (<tt class="docutils literal"><span class="pre">app/cache</span></tt>), директория для логов (<tt class="docutils literal"><span class="pre">app/logs</span></tt>) и директория для ресурсов уровня приложения (<tt class="docutils literal"><span class="pre">app/Resources</span></tt>). YОб этих директориях подробнее будет рассказано в других главах.</p>
	  <div class="admonition-wrapper" id="autoloading-introduction-sidebar">
	    <div class="sidebar"></div><div class="admonition admonition-sidebar"><p class="first sidebar-title">Автозагрузка</p>
	      <p>При инициализации приложения подключается особый файл <tt class="docutils literal"><span class="pre">app/autoload.php</span></tt> - Этот файл отвечает за автозагрузку всех файлов из директорий
		<tt class="docutils literal"><span class="pre">src/</span></tt> и <tt class="docutils literal"><span class="pre">vendor/</span></tt>.</p>
	      <p>С использованием автозагрузки вам больше не придется беспокоиться об использовании выражений <tt class="docutils literal"><span class="pre">include</span></tt>
		или <tt class="docutils literal"><span class="pre">require</span></tt>. Вместо этого, Symfony2 использует пространства имен классов, чтобы определить их расположение и автоматически подключить файл класса, в случае если класс вам понадобится:</p>
	      <div class="highlight-php"><div class="highlight"><pre><span class="nv">$loader</span><span class="o">-&gt;</span><span class="na">registerNamespaces</span><span class="p">(</span><span class="k">array</span><span class="p">(</span>
    <span class="s1">'Acme'</span> <span class="o">=&gt;</span> <span class="nx">__DIR__</span><span class="o">.</span><span class="s1">'/../src'</span><span class="p">,</span>
    <span class="c1">// ...</span>
<span class="p">));</span>
		</pre></div>
	      </div>
	      <p>При такой конфигурации, Symfony2 будет искать в директории <tt class="docutils literal"><span class="pre">src</span></tt> классы из пространства имен <tt class="docutils literal"><span class="pre">Acme</span></tt> (вы скорее всего будете использовать наименование вашей компании). Для того чтобы эта парадигма работала, необходимо чтобы имя класса и путь к нему соответствовали следующему шаблону:</p>
	      <div class="highlight-text"><div class="highlight"><pre>Class Name:
    Acme\HelloBundle\Controller\HelloController
Path:
    src/Acme/HelloBundle/Controller/HelloController.php
		</pre></div>
	      </div>
	      <p class="last">Файл <tt class="docutils literal"><span class="pre">app/autoload.php</span></tt> конфигурирует автозагрузчик и указывает ему, где искать классы из различных пространств имен и при необходимости может быть гибко настроен. Если вы хотите узнать больше об автозагрузке, смотрите статью в “поваренной книге” (без перевода): <a class="reference internal" href="../cookbook/tools/autoloader.html"><em>How to autoload Classes</em></a>.</p>
	  </div></div>
	</div>
	<div class="section" id="the-source-src-directory">
	  <h3>Директория исходных кодов проекта (<tt class="docutils literal"><span class="pre">src</span></tt>)<a class="headerlink" href="#the-source-src-directory" title="Permalink to this headline">¶</a></h3>
	  <p>Если вкратце, директория <tt class="docutils literal"><span class="pre">src/</span></tt> содержит весь код приложения. Фактически, во время разработки, большую часть работ вы будете производить именно в этой директории. По умолчанию, директория <tt class="docutils literal"><span class="pre">src/</span></tt> нового проекта пуста. Когда вы начинаете разработку, вы постепенно наполняете ее <em>пакетами</em>, которые содержат код приложения.</p>
	  <p>Но что же собственно из себя представляет сам <a class="reference internal" href="../glossary.html#term-bundle"><em class="xref std std-term">пакет</em></a>?</p>
	</div>
      </div>
      <div class="section" id="the-bundle-system">
	<span id="page-creation-bundles"></span><h2>Система пакетов<a class="headerlink" href="#the-bundle-system" title="Permalink to this headline">¶</a></h2>
	<p>Пакет чем-то схож с плагином, но он ещё лучше. Ключевое отличие состоит в том, что <em>всё</em> есть пакет в Symfony2, включая функционал ядра и код вашего приложения.
	  Пакеты – это граждане высшего сорта в Symfony2. Они дают вам возможность использовать уже готовые пакеты, которые вы можете найти по адресу <a class="reference external" href="http://symfony2bundles.org/">symfony2bundles.org</a>. Вы также можете там выкладывать свои пакеты. Они также дают возможность легко и просто выбрать, какие именно функции подключить в вашем приложении.</p>
	<div class="admonition-wrapper">
	  <div class="note"></div><div class="admonition admonition-note"><p class="first admonition-title">Note</p>
	    <p class="last">Здесь мы рассмотрим лишь основы, более детальную информацию по пакетам вы можете найти в главе <a class="reference internal" href="bundles.html"><em>Пакеты</em></a>.</p>
	</div></div>
	<p>Пакет это просто структурированный набор файлов и директорий, который реализует одну конкретную функцию. Вы можете создать BlogBundle или ForumBundle или же пакет для управления пользователями (такие пакеты уже есть и даже с открытым исходным кодом). Каждая директория содержит все необходимое для реализации этой конкретной функции, включая PHP файлы, шаблоны, стили, клиентские скрипты, тесты и все что ещё потребуется. Каждый аспект реализации функции находится в своём пакете и каждая функция располагается в своем собственном пакете.</p>
	<p>Приложение состоит из пакетов, которые объявлены в методе <tt class="docutils literal"><span class="pre">registerBundles()</span></tt>
	  класса <tt class="docutils literal"><span class="pre">AppKernel</span></tt>:</p>
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

        <span class="c1">// register your bundles</span>
        <span class="k">new</span> <span class="nx">Acme\HelloBundle\AcmeHelloBundle</span><span class="p">(),</span>
    <span class="p">);</span>

    <span class="k">if</span> <span class="p">(</span><span class="nb">in_array</span><span class="p">(</span><span class="nv">$this</span><span class="o">-&gt;</span><span class="na">getEnvironment</span><span class="p">(),</span> <span class="k">array</span><span class="p">(</span><span class="s1">'dev'</span><span class="p">,</span> <span class="s1">'test'</span><span class="p">)))</span> <span class="p">{</span>
        <span class="nv">$bundles</span><span class="p">[]</span> <span class="o">=</span> <span class="k">new</span> <span class="nx">Symfony\Bundle\WebProfilerBundle\WebProfilerBundle</span><span class="p">();</span>
    <span class="p">}</span>

    <span class="k">return</span> <span class="nv">$bundles</span><span class="p">;</span>
<span class="p">}</span>
	  </pre></div>
	</div>
	<p>Используя метод <tt class="docutils literal"><span class="pre">registerBundles()</span></tt>, вы получаете полный контроль над теми пакетами, которые используются вашим приложением (включая пакеты, входящие в состав ядра Symfony).</p>
	<div class="admonition-wrapper">
	  <div class="tip"></div><div class="admonition admonition-tip"><p class="first admonition-title">Tip</p>
	    <p class="last">Вообще говоря, пакет может располагаться <em>где угодно</em> , если конечно его расположение не мешает автозагрузчику Symfony2. Например, если <tt class="docutils literal"><span class="pre">AcmeHelloBundle</span></tt> расположен в директории <tt class="docutils literal"><span class="pre">src/Acme</span></tt>, озаботьтесь тем, чтобы пространство имён <tt class="docutils literal"><span class="pre">Acme</span></tt> было добавлено в файл
	      <tt class="docutils literal"><span class="pre">app/autoload.php</span></tt> и было направлено (mapped) на директорию <tt class="docutils literal"><span class="pre">src</span></tt>.</p>
	</div></div>
	<div class="section" id="creating-a-bundle">
	  <h3>Создание пакета<a class="headerlink" href="#creating-a-bundle" title="Permalink to this headline">¶</a></h3>
	  <p>Чтобы показать вам как проста система пакетов, давайте создадим новый пакет, назовём его
	    <tt class="docutils literal"><span class="pre">AcmeTestBundle</span></tt> и активируем его.</p>
	  <p>В первую очередь, создадим директорию <tt class="docutils literal"><span class="pre">src/Acme/TestBundle/</span></tt> и добавим в неё файл <tt class="docutils literal"><span class="pre">AcmeTestBundle.php</span></tt>:</p>
	  <div class="highlight-php"><div class="highlight"><pre><span class="c1">// src/Acme/TestBundle/AcmeTestBundle.php</span>
<span class="k">namespace</span> <span class="nx">Acme\TestBundle</span><span class="p">;</span>

<span class="k">use</span> <span class="nx">Symfony\Component\HttpKernel\Bundle\Bundle</span><span class="p">;</span>

<span class="k">class</span> <span class="nc">AcmeTestBundle</span> <span class="k">extends</span> <span class="nx">Bundle</span>
<span class="p">{</span>
<span class="p">}</span>
	    </pre></div>
	  </div>
	  <div class="admonition-wrapper">
	    <div class="tip"></div><div class="admonition admonition-tip"><p class="first admonition-title">Tip</p>
	      <p class="last">Наименование <tt class="docutils literal"><span class="pre">AcmeTestBundle</span></tt> следует <a class="reference internal" href="bundles.html#bundles-naming-conventions"><em>соглашениям по именованию пакетов</em></a>.</p>
	  </div></div>
	  <p>Этот пустой класс – единственное, что необходимо создать для минимальной комплектации пакета. Не смотря на то, что класс пуст, он обладает большим потенциалом и позволяет настраивать поведение пакета.</p>
	  <p>Теперь, когда мы создали пакет, его нужно активировать в классе <tt class="docutils literal"><span class="pre">AppKernel</span></tt>:</p>
	  <div class="highlight-php"><div class="highlight"><pre><span class="c1">// app/AppKernel.php</span>
<span class="k">public</span> <span class="k">function</span> <span class="nf">registerBundles</span><span class="p">()</span>
<span class="p">{</span>
    <span class="nv">$bundles</span> <span class="o">=</span> <span class="k">array</span><span class="p">(</span>
        <span class="c1">// ...</span>

        <span class="c1">// register your bundles</span>
        <span class="k">new</span> <span class="nx">Acme\TestBundle\AcmeTestBundle</span><span class="p">(),</span>
    <span class="p">);</span>

    <span class="c1">// ...</span>

    <span class="k">return</span> <span class="nv">$bundles</span><span class="p">;</span>
<span class="p">}</span>
	    </pre></div>
	  </div>
	  <p>И, хотя наш новый пакет пока ничего не делает, он готов к использованию.</p>
	  <p>Symfony также предлагает интерфейс для командной строки для создания базового каркаса пакета:</p>
	  <div class="highlight-php"><div class="highlight"><pre><span class="nx">php</span> <span class="nx">app</span><span class="o">/</span><span class="nx">console</span> <span class="nx">init</span><span class="o">:</span><span class="nx">bundle</span> <span class="nx">Acme</span><span class="o">/</span><span class="nx">TestBundle</span> <span class="nx">src</span>
	    </pre></div>
	  </div>
	  <p>Каркас пакета создаёт базовый контроллер, шаблон и маршрут, которые можно настроить. Мы еще вернёмся к инструментам командной строки позже.</p>
	  <div class="admonition-wrapper">
	    <div class="tip"></div><div class="admonition admonition-tip"><p class="first admonition-title">Tip</p>
	      <p class="last">Когда создаёте новый пакет, или используете сторонние пакеты, убедитесь, что пакет активирован в <tt class="docutils literal"><span class="pre">registerBundles()</span></tt>.</p>
	  </div></div>
	</div>
	<div class="section" id="bundle-directory-structure">
	  <h3>Структура директории пакета<a class="headerlink" href="#bundle-directory-structure" title="Permalink to this headline">¶</a></h3>
	  <p>Структура директории пакета проста и гибка. По умолчанию, система пакетов следует некоторым соглашениям, которые помогают поддерживать стилевое единообразие во всех пакетах Symfony2. Давайте взглянем на пакет <tt class="docutils literal"><span class="pre">AcmeHelloBundle</span></tt>, так как он содержит наиболее основные элементы пакета:</p>
	  <ul class="simple">
	    <li><em>Controller/</em> содержит контроллеры (например <tt class="docutils literal"><span class="pre">HelloController.php</span></tt>);</li>
	    <li><em>Resources/config/</em> место для конфигурационных файлов, включая конфигурацию маршрутизатора (например <tt class="docutils literal"><span class="pre">routing.yml</span></tt>);</li>
	    <li><em>Resources/views/</em> шаблоны, сгруппированные по имени контроллера (например <tt class="docutils literal"><span class="pre">Hello/index.html.twig</span></tt>);</li>
	    <li><em>Resources/public/</em> публично доступные ресурсы (картинки, стили…), которые будут скопированы или связаны символической ссылкой с <tt class="docutils literal"><span class="pre">web/</span></tt> директорией;</li>
	    <li><em>Tests/</em> содержит все тесты.</li>
	  </ul>
	  <p>Пакет может быть как маленьким, так и большим – в зависимости от задачи, которую он реализует. Он содержит лишь те файлы, которые нужны – и ничего более.</p>
	  <p>В других главах книги вы также узнаете как работать с базой данных, как создавать и валидировать формы, создавать файлы переводов, писать тесты и много чего ещё. Все эти объекты в пакете имеют определенную роль и место.</p>
	</div>
      </div>
      <div class="section" id="application-configuration">
	<h2>Настройка приложения<a class="headerlink" href="#application-configuration" title="Permalink to this headline">¶</a></h2>
	<p>Приложение состоит из набора пакетов, реализующих все необходимые функции вашего приложения. Каждый пакет может быть настроен при помощи конфигурационных файлов, написанных на YAML, XML или PHP. По умолчанию, основной конфигурационный файл расположен в директории <tt class="docutils literal"><span class="pre">app/config/</span></tt> и называется
	  either <tt class="docutils literal"><span class="pre">config.yml</span></tt>, <tt class="docutils literal"><span class="pre">config.xml</span></tt> or <tt class="docutils literal"><span class="pre">config.php</span></tt>, в зависимости от предпочитаемого вами формата:</p>
	<div class="configuration-block jsactive clearfix">
	  <ul class="simple" style="height: 382px; ">
	    <li class="selected"><em><a href="#">YAML</a></em><div class="highlight-yaml" style="width: 690px; display: block; "><pre># app/config/config.yml
framework:
    charset:         UTF-8
    secret:          xxxxxxxxxx
    form:            true
    csrf_protection: true
    router:          { resource: "%kernel.root_dir%/config/routing.yml" }
    validation:      { enable_annotations: true }
    templating:      { engines: ['twig'] } #assets_version: SomeVersionScheme
    session:
        default_locale: en
        lifetime:       3600
        auto_start:     true

# Twig Configuration
twig:
    debug:            %kernel.debug%
		  strict_variables: %kernel.debug%</pre>
	      </div>
	    </li>
	    <li><em><a href="#">XML</a></em><div class="highlight-xml" style="display: none; width: 690px; "><div class="highlight"><pre><span class="c">&lt;!-- app/config/config.xml --&gt;</span>
<span class="nt">&lt;framework:config</span> <span class="na">charset=</span><span class="s">"UTF-8"</span> <span class="na">error-handler=</span><span class="s">"null"</span> <span class="na">cache-warmer=</span><span class="s">"false"</span> <span class="na">secret=</span><span class="s">"xxxxxxxxxx"</span><span class="nt">&gt;</span>
    <span class="nt">&lt;framework:router</span> <span class="na">resource=</span><span class="s">"%kernel.root_dir%/config/routing.xml"</span> <span class="na">cache-warmer=</span><span class="s">"true"</span> <span class="nt">/&gt;</span>
    <span class="nt">&lt;framework:validation</span> <span class="na">annotations=</span><span class="s">"true"</span> <span class="nt">/&gt;</span>
    <span class="nt">&lt;framework:session</span> <span class="na">default-locale=</span><span class="s">"en"</span> <span class="na">lifetime=</span><span class="s">"3600"</span> <span class="na">auto-start=</span><span class="s">"true"</span> <span class="nt">/&gt;</span>
    <span class="nt">&lt;framework:templating</span> <span class="na">assets-version=</span><span class="s">"SomeVersionScheme"</span> <span class="na">cache-warmer=</span><span class="s">"true"</span><span class="nt">&gt;</span>
        <span class="nt">&lt;framework:engine</span> <span class="na">id=</span><span class="s">"twig"</span> <span class="nt">/&gt;</span>
    <span class="nt">&lt;/framework:templating&gt;</span>
    <span class="nt">&lt;framework:form</span> <span class="nt">/&gt;</span>
    <span class="nt">&lt;framework:csrf-protection</span> <span class="nt">/&gt;</span>
<span class="nt">&lt;/framework:config&gt;</span>

<span class="c">&lt;!-- Twig Configuration --&gt;</span>
<span class="nt">&lt;twig:config</span> <span class="na">debug=</span><span class="s">"%kernel.debug%"</span> <span class="na">strict-variables=</span><span class="s">"%kernel.debug%"</span> <span class="na">cache-warmer=</span><span class="s">"true"</span> <span class="nt">/&gt;</span>
		</pre></div>
	      </div>
	    </li>
	    <li><em><a href="#">PHP</a></em><div class="highlight-php" style="display: none; width: 690px; "><div class="highlight"><pre><span class="nv">$container</span><span class="o">-&gt;</span><span class="na">loadFromExtension</span><span class="p">(</span><span class="s1">'framework'</span><span class="p">,</span> <span class="k">array</span><span class="p">(</span>
    <span class="s1">'charset'</span>         <span class="o">=&gt;</span> <span class="s1">'UTF-8'</span><span class="p">,</span>
    <span class="s1">'secret'</span>          <span class="o">=&gt;</span> <span class="s1">'xxxxxxxxxx'</span><span class="p">,</span>
    <span class="s1">'form'</span>            <span class="o">=&gt;</span> <span class="k">array</span><span class="p">(),</span>
    <span class="s1">'csrf-protection'</span> <span class="o">=&gt;</span> <span class="k">array</span><span class="p">(),</span>
    <span class="s1">'router'</span>          <span class="o">=&gt;</span> <span class="k">array</span><span class="p">(</span><span class="s1">'resource'</span> <span class="o">=&gt;</span> <span class="s1">'%kernel.root_dir%/config/routing.php'</span><span class="p">),</span>
    <span class="s1">'validation'</span>      <span class="o">=&gt;</span> <span class="k">array</span><span class="p">(</span><span class="s1">'annotations'</span> <span class="o">=&gt;</span> <span class="k">true</span><span class="p">),</span>
    <span class="s1">'templating'</span>      <span class="o">=&gt;</span> <span class="k">array</span><span class="p">(</span>
        <span class="s1">'engines'</span> <span class="o">=&gt;</span> <span class="k">array</span><span class="p">(</span><span class="s1">'twig'</span><span class="p">),</span>
        <span class="c1">#'assets_version' =&gt; "SomeVersionScheme",</span>
    <span class="p">),</span>
    <span class="s1">'session'</span> <span class="o">=&gt;</span> <span class="k">array</span><span class="p">(</span>
        <span class="s1">'default_locale'</span> <span class="o">=&gt;</span> <span class="s2">"en"</span><span class="p">,</span>
        <span class="s1">'lifetime'</span>       <span class="o">=&gt;</span> <span class="s2">"3600"</span><span class="p">,</span>
        <span class="s1">'auto_start'</span>     <span class="o">=&gt;</span> <span class="k">true</span><span class="p">,</span>
    <span class="p">),</span>
<span class="p">));</span>

<span class="c1">// Twig Configuration</span>
<span class="nv">$container</span><span class="o">-&gt;</span><span class="na">loadFromExtension</span><span class="p">(</span><span class="s1">'twig'</span><span class="p">,</span> <span class="k">array</span><span class="p">(</span>
    <span class="s1">'debug'</span>            <span class="o">=&gt;</span> <span class="s1">'%kernel.debug%'</span><span class="p">,</span>
    <span class="s1">'strict_variables'</span> <span class="o">=&gt;</span> <span class="s1">'%kernel.debug%'</span><span class="p">,</span>
<span class="p">));</span>
		</pre></div>
	      </div>
	    </li>
	  </ul>
	</div>
	<div class="admonition-wrapper">
	  <div class="note"></div><div class="admonition admonition-note"><p class="first admonition-title">Note</p>
	    <p class="last">О том как выбрать какой файл/формат загружать – мы рассмотрим в следующей секции <a class="reference internal" href="#environments">Окружения</a>.</p>
	</div></div>
	<p>Каждый параметр верхнего уровня, например <tt class="docutils literal"><span class="pre">framework</span></tt> или <tt class="docutils literal"><span class="pre">twig</span></tt>, определяет настройки конкретного пакета. Например, ключ <tt class="docutils literal"><span class="pre">framework</span></tt> определяет настройки ядра Symfony <tt class="docutils literal"><span class="pre">FrameworkBundle</span></tt> и включает настройки маршрутизации, шаблонизатора и прочих ключевых систем.</p>
	<p>Пока же нам не стоит беспокоиться о конкретных настройках в каждой секции. Файл настроек по умолчанию содержит все необходимые параметры. По ходу чтения прочей документации вы ознакомитесь со всеми специфическими настройками.</p>
	<div class="admonition-wrapper">
	  <div class="sidebar"></div><div class="admonition admonition-sidebar"><p class="first sidebar-title">Форматы конфигураций</p>
	    <p>Во всех главах книги все примеры конфигураций будут показаны во всех трех форматах (YAML, XML and PHP). Каждый из них имеет свои достоинства и недостатки. Выбор же формата целиком зависит о ваших предпочтений:</p>
	    <ul class="last simple">
	      <li><em>YAML</em>: Простой, понятный и читабльный;</li>
	      <li><em>XML</em>: В разы более мощный, нежели YAML. Поддерживается многими IDE (autocompletion);</li>
	      <li><em>PHP</em>: Очень мощный, но менее читабельный, чем стандартные форматы конфигурационных файлов.</li>
	    </ul>
	</div></div>
      </div>
      <div class="section" id="environments">
	<span id="environments-summary"></span><span id="index-3"></span><h2>Окружения<a class="headerlink" href="#environments" title="Permalink to this headline">¶</a></h2>
	<p>Приложение можно запускать в различных окружениях. Различные окружения используют один и тот же PHP код (за исключением фронт-контроллера), но могут иметь совершенно различные настройки. Например, <tt class="docutils literal"><span class="pre">dev</span></tt> окружение ведет лог ошибок и замечаний, в то время как <tt class="docutils literal"><span class="pre">prod</span></tt> окружение логгирует только ошибки. В <tt class="docutils literal"><span class="pre">dev</span></tt> некоторые файлы пересоздаются при каждом запросе, но кешируются в
	  <tt class="docutils literal"><span class="pre">prod</span></tt> окружении. В то же время, все окружения одновременно доступны на одной и той же машине.</p>
	<p>Проект Symfony2 по умолчанию имеет три окружения (<tt class="docutils literal"><span class="pre">dev</span></tt>, <tt class="docutils literal"><span class="pre">test</span></tt>
	  и <tt class="docutils literal"><span class="pre">prod</span></tt>), хотя создать новое окружение не сложно. Вы можете смотреть ваше приложение в различных окружениях просто меняя фронт-контроллеры в браузере. Для того чтобы отобразить приложение в <tt class="docutils literal"><span class="pre">dev</span></tt> окружении, откройте его при помощи фронт контроллера app_dev.php:</p>
	<div class="highlight-php"><div class="highlight"><pre><span class="nx">http</span><span class="o">://</span><span class="nx">localhost</span><span class="o">/</span><span class="nx">app_dev</span><span class="o">.</span><span class="nx">php</span><span class="o">/</span><span class="nx">hello</span><span class="o">/</span><span class="nx">Ryan</span>
	  </pre></div>
	</div>
	<p>Если же вы хотите посмотреть, как поведёт себя приложение в продуктовой среде, вы можете вызвать фронт-контроллер <tt class="docutils literal"><span class="pre">prod</span></tt>:</p>
	<div class="highlight-php"><div class="highlight"><pre><span class="nx">http</span><span class="o">://</span><span class="nx">localhost</span><span class="o">/</span><span class="nx">app</span><span class="o">.</span><span class="nx">php</span><span class="o">/</span><span class="nx">hello</span><span class="o">/</span><span class="nx">Ryan</span>
	  </pre></div>
	</div>
	<div class="admonition-wrapper">
	  <div class="note"></div><div class="admonition admonition-note"><p class="first admonition-title">Note</p>
	    <p>Если вы откроете файл <tt class="docutils literal"><span class="pre">web/app.php</span></tt>, вы обнаружите, что он однозначно настроен на использование <tt class="docutils literal"><span class="pre">prod</span></tt> окружения:</p>
	    <div class="highlight-php"><div class="highlight"><pre><span class="nv">$kernel</span> <span class="o">=</span> <span class="k">new</span> <span class="nx">AppCache</span><span class="p">(</span><span class="k">new</span> <span class="nx">AppKernel</span><span class="p">(</span><span class="s1">'prod'</span><span class="p">,</span> <span class="k">false</span><span class="p">));</span>
	      </pre></div>
	    </div>
	    <p class="last">Вы можете создать новый фронт-контроллер для нового окружения просто скопировав этот файл и изменив <tt class="docutils literal"><span class="pre">prod</span></tt> на другое значение.</p>
	</div></div>
	<p>Так как <tt class="docutils literal"><span class="pre">prod</span></tt> окружение оптимизировано для скорости, настройки, маршруты и шаблоны Twig компилируются в плоские PHP классы и кешируются. Когда вы хотите посмотреть изменения в продуктовом окружении, вам потребуется удалить эти файлы чтобы они пересоздались автоматически:</p>
	<div class="highlight-php"><div class="highlight"><pre><span class="nx">rm</span> <span class="o">-</span><span class="nx">rf</span> <span class="nx">app</span><span class="o">/</span><span class="nx">cache</span><span class="o">/*</span>
	  </pre></div>
	</div>
	<div class="admonition-wrapper">
	  <div class="note"></div><div class="admonition admonition-note"><p class="first admonition-title">Note</p>
	    <p class="last">Тестовое окружение <tt class="docutils literal"><span class="pre">test</span></tt> используется при запуске автотестов и его нельзя напрямую открыть через браузер. Подробнее об это можно почитать в <a class="reference internal" href="testing.html"><em>главе про тестирование</em></a>.</p>
	</div></div>
	<div class="section" id="environment-configuration">
	  <span id="index-4"></span><h3>Настройка окружений<a class="headerlink" href="#environment-configuration" title="Permalink to this headline">¶</a></h3>
	  <p>Класс <tt class="docutils literal"><span class="pre">AppKernel</span></tt> отвечает за загрузку конфигурационных файлов:</p>
	  <div class="highlight-php"><div class="highlight"><pre><span class="c1">// app/AppKernel.php</span>
<span class="k">public</span> <span class="k">function</span> <span class="nf">registerContainerConfiguration</span><span class="p">(</span><span class="nx">LoaderInterface</span> <span class="nv">$loader</span><span class="p">)</span>
<span class="p">{</span>
    <span class="nv">$loader</span><span class="o">-&gt;</span><span class="na">load</span><span class="p">(</span><span class="nx">__DIR__</span><span class="o">.</span><span class="s1">'/config/config_'</span><span class="o">.</span><span class="nv">$this</span><span class="o">-&gt;</span><span class="na">getEnvironment</span><span class="p">()</span><span class="o">.</span><span class="s1">'.yml'</span><span class="p">);</span>
<span class="p">}</span>
	    </pre></div>
	  </div>
	  <p>Мы уже знаем, что расширение <tt class="docutils literal"><span class="pre">.yml</span></tt> может быть изменено на <tt class="docutils literal"><span class="pre">.xml</span></tt> или
	    <tt class="docutils literal"><span class="pre">.php</span></tt>, если вы предпочитаете использовать XML или PHP. Имейте также в виду, что каждое окружение загружает свои собственные настройки. Рассмотрим конфигурационный файл для <tt class="docutils literal"><span class="pre">dev</span></tt> окружения.</p>
	  <div class="configuration-block jsactive clearfix">
	    <ul class="simple" style="height: 346px; ">
	      <li class="selected"><em><a href="#">YAML</a></em><div class="highlight-yaml" style="width: 690px; display: block; "><pre># app/config/config_dev.yml
imports:
    - { resource: config.yml }

framework:
    router:   { resource: "%kernel.root_dir%/config/routing_dev.yml" }
    profiler: { only_exceptions: false }

web_profiler:
    toolbar: true
    intercept_redirects: true

zend:
    logger:
        priority: debug
		    path:     %kernel.logs_dir%/%kernel.environment%.log</pre>
		</div>
	      </li>
	      <li><em><a href="#">XML</a></em><div class="highlight-xml" style="display: none; width: 690px; "><div class="highlight"><pre><span class="c">&lt;!-- app/config/config_dev.xml --&gt;</span>
<span class="nt">&lt;imports&gt;</span>
    <span class="nt">&lt;import</span> <span class="na">resource=</span><span class="s">"config.xml"</span> <span class="nt">/&gt;</span>
<span class="nt">&lt;/imports&gt;</span>

<span class="nt">&lt;framework:config&gt;</span>
    <span class="nt">&lt;framework:router</span> <span class="na">resource=</span><span class="s">"%kernel.root_dir%/config/routing_dev.xml"</span> <span class="nt">/&gt;</span>
    <span class="nt">&lt;framework:profiler</span> <span class="na">only-exceptions=</span><span class="s">"false"</span> <span class="nt">/&gt;</span>
<span class="nt">&lt;/framework:config&gt;</span>

<span class="nt">&lt;webprofiler:config</span>
    <span class="na">toolbar=</span><span class="s">"true"</span>
    <span class="na">intercept-redirects=</span><span class="s">"true"</span>
<span class="nt">/&gt;</span>

<span class="nt">&lt;zend:config&gt;</span>
    <span class="nt">&lt;zend:logger</span> <span class="na">priority=</span><span class="s">"info"</span> <span class="na">path=</span><span class="s">"%kernel.logs_dir%/%kernel.environment%.log"</span> <span class="nt">/&gt;</span>
<span class="nt">&lt;/zend:config&gt;</span>
		  </pre></div>
		</div>
	      </li>
	      <li><em><a href="#">PHP</a></em><div class="highlight-php" style="display: none; width: 690px; "><div class="highlight"><pre><span class="c1">// app/config/config_dev.php</span>
<span class="nv">$loader</span><span class="o">-&gt;</span><span class="na">import</span><span class="p">(</span><span class="s1">'config.php'</span><span class="p">);</span>

<span class="nv">$container</span><span class="o">-&gt;</span><span class="na">loadFromExtension</span><span class="p">(</span><span class="s1">'framework'</span><span class="p">,</span> <span class="k">array</span><span class="p">(</span>
    <span class="s1">'router'</span>   <span class="o">=&gt;</span> <span class="k">array</span><span class="p">(</span><span class="s1">'resource'</span> <span class="o">=&gt;</span> <span class="s1">'%kernel.root_dir%/config/routing_dev.php'</span><span class="p">),</span>
    <span class="s1">'profiler'</span> <span class="o">=&gt;</span> <span class="k">array</span><span class="p">(</span><span class="s1">'only-exceptions'</span> <span class="o">=&gt;</span> <span class="k">false</span><span class="p">),</span>
<span class="p">));</span>

<span class="nv">$container</span><span class="o">-&gt;</span><span class="na">loadFromExtension</span><span class="p">(</span><span class="s1">'web_profiler'</span><span class="p">,</span> <span class="k">array</span><span class="p">(</span>
    <span class="s1">'toolbar'</span> <span class="o">=&gt;</span> <span class="k">true</span><span class="p">,</span>
    <span class="s1">'intercept-redirects'</span> <span class="o">=&gt;</span> <span class="k">true</span><span class="p">,</span>
<span class="p">));</span>

<span class="nv">$container</span><span class="o">-&gt;</span><span class="na">loadFromExtension</span><span class="p">(</span><span class="s1">'zend'</span><span class="p">,</span> <span class="k">array</span><span class="p">(</span>
    <span class="s1">'logger'</span> <span class="o">=&gt;</span> <span class="k">array</span><span class="p">(</span>
        <span class="s1">'priority'</span> <span class="o">=&gt;</span> <span class="s1">'info'</span><span class="p">,</span>
        <span class="s1">'path'</span>     <span class="o">=&gt;</span> <span class="s1">'%kernel.logs_dir%/%kernel.environment%.log'</span><span class="p">,</span>
    <span class="p">),</span>
<span class="p">));</span>
		  </pre></div>
		</div>
	      </li>
	    </ul>
	  </div>
	  <p>Ключ <tt class="docutils literal"><span class="pre">imports</span></tt> похож по действию на выражение <tt class="docutils literal"><span class="pre">include</span></tt> в PHP и гарантирует что главный конфигурационный файл (<tt class="docutils literal"><span class="pre">config.yml</span></tt>) будет загружен в первую очередь. Остальной код корректирует конфигурацию по-умолчанию для увеличения порога логгирования и прочих настроек, специфичных для разработки.</p>
	  <p>Оба окружения – <tt class="docutils literal"><span class="pre">prod</span></tt> и <tt class="docutils literal"><span class="pre">test</span></tt> следуют той же модели: каждое окружение импортирует базовые настройки и модифицирует их значения для своих нужд.</p>
	</div>
      </div>
      <div class="section" id="summary">
	<h2>Заключение<a class="headerlink" href="#summary" title="Permalink to this headline">¶</a></h2>
	<p>Поздравляем! Вы усвоили все фундаментальные аспекты Symfony2 и обнаружили, какими лёгкими и в то же время гибкими они могут быть. И, поскольку на подходе ещё
	  <em>a lot</em> интересного, обязательно запомните следующие положения:</p>
	<ul class="simple">
	  <li>создание страниц – это три простых шага, включающих <strong>маршрут</strong>, <strong>контроллер</strong>
	    и (опционально) <strong>шаблон</strong>.</li>
	  <li>Каждое приложение должно состоять только из 4х директорий: <strong>web/</strong> (web assets и front controllers), <strong>app/</strong> (configuration), <strong>src/</strong> (ваши пакеты),
	    и <strong>vendor/</strong> (сторонние библиотеки);</li>
	  <li>Каждая функция в Symfony2 (включая ядро фреймворка) должна располагаться внутри <em>bundle</em>, который представляет собой структурированный набор файлов, реализующих эту функцию;</li>
	  <li><strong>настройки</strong> каждого пакета располагаются в директории <tt class="docutils literal"><span class="pre">app/config</span></tt> и могут быть записаны в формате YAML, XML или PHP;</li>
	  <li>каждое <strong>окружение</strong> доступно через свой отдельный фронт-контроллер (например
	    <tt class="docutils literal"><span class="pre">app.php</span></tt> и <tt class="docutils literal"><span class="pre">app_dev.php</span></tt>) и заружает отдельный файл настроек.</li>
	</ul>
	<p>Далее, каждая глава книги познакомит вас с все более и более мощными инструментами и более глубокими концепциями. Чем больше вы знаете о Symfony2, тем больше вы будете ценить гибкость его архитектуры и его обширные возможности для быстрой разработки приложений.</p>
      </div>
      <div class="section" id="learn-more-from-the-cookbook">
	<h2>Узнайте больше из книги рецептов<a class="headerlink" href="#learn-more-from-the-cookbook" title="Permalink to this headline">¶</a></h2>
	<ul class="simple">
	  <li><a class="reference internal" href="../cookbook/controller/service.html"><em>How to define Controllers as Services</em></a></li>
	  <li><a class="reference internal" href="../cookbook/templating/PHP.html"><em>How to use PHP instead of Twig for Templates</em></a></li>
	  <li><a class="reference internal" href="../cookbook/tools/autoloader.html"><em>How to autoload Classes</em></a></li>
	  <li><a class="reference internal" href="../cookbook/symfony1.html"><em>How Symfony2 differs from symfony1</em></a></li>
	</ul>
      </div>
    </div>


    

  </div>

  <div class="navigation">
    <a accesskey="P" title="Installing and Configuring Symfony" href="installation.html">
      «&nbsp;Установка и настройка Symfony
    </a><span class="separator">|</span>
    <a accesskey="N" title="The Controller" href="controller.html">
      Контроллеры&nbsp;»
    </a>
  </div>

  <div class="box_hr"><hr></div>

</div>
