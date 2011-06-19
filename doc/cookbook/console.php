<?php include(__DIR__.'/../_doc.php')?>
<div class="column_02">

  <div class="box_title">
    <h1 class="title_01">How to create Console/Command-Line Commands</h1>
  </div>
  
  

  <div class="box_article doc_page">

    
    
    <div class="section" id="how-to-create-console-command-line-commands">
      <h1>How to create Console/Command-Line Commands<a class="headerlink" href="#how-to-create-console-command-line-commands" title="Permalink to this headline">¶</a></h1>
      <p>Symfony2 ships with a Console component, which allows you to create
	command-line commands. Your console commands can be used for any recurring
	task, such as cronjobs, imports, or other batch jobs.</p>
      <div class="section" id="creating-a-basic-command">
	<h2>Creating a basic Command<a class="headerlink" href="#creating-a-basic-command" title="Permalink to this headline">¶</a></h2>
	<p>To make the console commands available automatically with Symfony2, create a
	  <tt class="docutils literal"><span class="pre">Command</span></tt> directory inside your bundle and create a php file suffixed with
	  <tt class="docutils literal"><span class="pre">Command.php</span></tt> for each command that you want to provide. For example, if you
	  want to extend the <tt class="docutils literal"><span class="pre">AcmeDemoBundle</span></tt> (available in the Symfony Standard
	  Edition) to greet us from the command line, create <tt class="docutils literal"><span class="pre">GreetCommand.php</span></tt> and
	  add the following to it:</p>
	<div class="highlight-php"><div class="highlight"><pre><span class="c1">// src/Acme/DemoBundle/Command/GreetCommand.php</span>
<span class="k">namespace</span> <span class="nx">Acme\DemoBundle\Command</span><span class="p">;</span>

<span class="k">use</span> <span class="nx">Symfony\Bundle\FrameworkBundle\Command\Command</span><span class="p">;</span>
<span class="k">use</span> <span class="nx">Symfony\Component\Console\Input\InputArgument</span><span class="p">;</span>
<span class="k">use</span> <span class="nx">Symfony\Component\Console\Input\InputInterface</span><span class="p">;</span>
<span class="k">use</span> <span class="nx">Symfony\Component\Console\Input\InputOption</span><span class="p">;</span>
<span class="k">use</span> <span class="nx">Symfony\Component\Console\Output\OutputInterface</span><span class="p">;</span>

<span class="k">class</span> <span class="nc">GreetCommand</span> <span class="k">extends</span> <span class="nx">Command</span>
<span class="p">{</span>
    <span class="k">protected</span> <span class="k">function</span> <span class="nf">configure</span><span class="p">()</span>
    <span class="p">{</span>
        <span class="nv">$this</span>
            <span class="o">-&gt;</span><span class="na">setName</span><span class="p">(</span><span class="s1">'demo:greet'</span><span class="p">)</span>
            <span class="o">-&gt;</span><span class="na">setDescription</span><span class="p">(</span><span class="s1">'Greet someone'</span><span class="p">)</span>
            <span class="o">-&gt;</span><span class="na">addArgument</span><span class="p">(</span><span class="s1">'name'</span><span class="p">,</span> <span class="nx">InputArgument</span><span class="o">::</span><span class="na">OPTIONAL</span><span class="p">,</span> <span class="s1">'Who do you want to greet?'</span><span class="p">)</span>
            <span class="o">-&gt;</span><span class="na">addOption</span><span class="p">(</span><span class="s1">'yell'</span><span class="p">,</span> <span class="k">null</span><span class="p">,</span> <span class="nx">InputOption</span><span class="o">::</span><span class="na">VALUE_NONE</span><span class="p">,</span> <span class="s1">'If set, the task will yell in uppercase letters'</span><span class="p">)</span>
        <span class="p">;</span>
    <span class="p">}</span>

    <span class="k">protected</span> <span class="k">function</span> <span class="nf">execute</span><span class="p">(</span><span class="nx">InputInterface</span> <span class="nv">$input</span><span class="p">,</span> <span class="nx">OutputInterface</span> <span class="nv">$output</span><span class="p">)</span>
    <span class="p">{</span>
        <span class="nv">$name</span> <span class="o">=</span> <span class="nv">$input</span><span class="o">-&gt;</span><span class="na">getArgument</span><span class="p">(</span><span class="s1">'name'</span><span class="p">);</span>
        <span class="k">if</span> <span class="p">(</span><span class="nv">$name</span><span class="p">)</span> <span class="p">{</span>
            <span class="nv">$text</span> <span class="o">=</span> <span class="s1">'Hello '</span><span class="o">.</span><span class="nv">$name</span><span class="p">;</span>
        <span class="p">}</span> <span class="k">else</span> <span class="p">{</span>
            <span class="nv">$text</span> <span class="o">=</span> <span class="s1">'Hello'</span><span class="p">;</span>
        <span class="p">}</span>

        <span class="k">if</span> <span class="p">(</span><span class="nv">$input</span><span class="o">-&gt;</span><span class="na">getOption</span><span class="p">(</span><span class="s1">'yell'</span><span class="p">))</span> <span class="p">{</span>
            <span class="nv">$text</span> <span class="o">=</span> <span class="nb">strtoupper</span><span class="p">(</span><span class="nv">$text</span><span class="p">);</span>
        <span class="p">}</span>

        <span class="nv">$output</span><span class="o">-&gt;</span><span class="na">writeln</span><span class="p">(</span><span class="nv">$text</span><span class="p">);</span>
    <span class="p">}</span>
<span class="p">}</span>
	  </pre></div>
	</div>
	<p>Test the new console command by running the following</p>
	<div class="highlight-bash"><div class="highlight"><pre><span class="nv">$ </span>php app/console demo:greet Fabien
	  </pre></div>
	</div>
	<p>This will print the following to the command line:</p>
	<div class="highlight-text"><div class="highlight"><pre>Hello Fabien
	  </pre></div>
	</div>
	<p>You can also use the <tt class="docutils literal"><span class="pre">--yell</span></tt> option to make everything uppercase:</p>
	<div class="highlight-bash"><div class="highlight"><pre><span class="nv">$ </span>php app/console demo:greet Fabien --yell
	  </pre></div>
	</div>
	<p>This prints:</p>
	<div class="highlight-php"><div class="highlight"><pre><span class="nx">HELLO</span> <span class="nx">FABIEN</span>
	  </pre></div>
	</div>
      </div>
      <div class="section" id="using-command-arguments">
	<h2>Using Command Arguments<a class="headerlink" href="#using-command-arguments" title="Permalink to this headline">¶</a></h2>
	<p>The most interesting part of the commands are the arguments and options that
	  you can make available. Arguments are the strings - separated by spaces - that
	  come after the command name itself. They are ordered, and can be optional
	  or required. For example, add an optional <tt class="docutils literal"><span class="pre">last_name</span></tt> argument to the command
	  and make the <tt class="docutils literal"><span class="pre">name</span></tt> argument required:</p>
	<div class="highlight-php"><div class="highlight"><pre><span class="nv">$this</span>
    <span class="c1">// ...</span>
    <span class="o">-&gt;</span><span class="na">addArgument</span><span class="p">(</span><span class="s1">'name'</span><span class="p">,</span> <span class="nx">InputArgument</span><span class="o">::</span><span class="na">REQUIRED</span><span class="p">,</span> <span class="s1">'Who do you want to greet?'</span><span class="p">)</span>
    <span class="o">-&gt;</span><span class="na">addArgument</span><span class="p">(</span><span class="s1">'last_name'</span><span class="p">,</span> <span class="nx">InputArgument</span><span class="o">::</span><span class="na">OPTIONAL</span><span class="p">,</span> <span class="s1">'Your last name?'</span><span class="p">)</span>
    <span class="c1">// ...</span>
	  </pre></div>
	</div>
	<p>You now have access to a <tt class="docutils literal"><span class="pre">last_name</span></tt> argument in your command:</p>
	<div class="highlight-php"><div class="highlight"><pre><span class="k">if</span> <span class="p">(</span><span class="nv">$lastName</span> <span class="o">=</span> <span class="nv">$input</span><span class="o">-&gt;</span><span class="na">getArgument</span><span class="p">(</span><span class="s1">'last_name'</span><span class="p">))</span> <span class="p">{</span>
    <span class="nv">$text</span> <span class="o">.=</span> <span class="s1">' '</span><span class="o">.</span><span class="nv">$lastName</span><span class="p">;</span>
<span class="p">}</span>
	  </pre></div>
	</div>
	<p>The command can now be used in either of the following ways:</p>
	<div class="highlight-bash"><div class="highlight"><pre><span class="nv">$ </span>php app/console demo:greet Fabien
<span class="nv">$ </span>php app/console demo:greet Fabien Potencier
	  </pre></div>
	</div>
      </div>
      <div class="section" id="using-command-options">
	<h2>Using Command Options<a class="headerlink" href="#using-command-options" title="Permalink to this headline">¶</a></h2>
	<p>Unlike arguments, options are not ordered (meaning you can specify them in any
	  order) and are specified with two dashes (e.g. <tt class="docutils literal"><span class="pre">--yell</span></tt> - you can also
	  declare a one-letter shortcut that you can call with a single dash like
	  <tt class="docutils literal"><span class="pre">-y</span></tt>). Options are <em>always</em> optional, and can be setup to accept a value
	  (e.g. <tt class="docutils literal"><span class="pre">dir=src</span></tt>) or simply as a boolean flag without a value (e.g.
	  <tt class="docutils literal"><span class="pre">yell</span></tt>).</p>
	<div class="admonition-wrapper">
	  <div class="tip"></div><div class="admonition admonition-tip"><p class="first admonition-title">Tip</p>
	    <p class="last">It is also possible to make an option <em>optionally</em> accept a value (so that
	      <tt class="docutils literal"><span class="pre">--yell</span></tt> or <tt class="docutils literal"><span class="pre">yell=loud</span></tt> work). Options can also be configured to
	      accept an array of values.</p>
	</div></div>
	<p>For example, add a new option to the command that can be used to specify
	  how many times in a row the message should be printed:</p>
	<div class="highlight-php"><div class="highlight"><pre><span class="nv">$this</span>
    <span class="c1">// ...</span>
    <span class="o">-&gt;</span><span class="na">addOption</span><span class="p">(</span><span class="s1">'iterations'</span><span class="p">,</span> <span class="k">null</span><span class="p">,</span> <span class="nx">InputOption</span><span class="o">::</span><span class="na">VALUE_REQUIRED</span><span class="p">,</span> <span class="s1">'How many times should the message be printed?'</span><span class="p">,</span> <span class="mi">1</span><span class="p">)</span>
	  </pre></div>
	</div>
	<p>Next, use this in the command to print the message multiple times:</p>
	<div class="highlight-php"><div class="highlight"><pre><span class="k">for</span> <span class="p">(</span><span class="nv">$i</span> <span class="o">=</span> <span class="mi">0</span><span class="p">;</span> <span class="nv">$i</span> <span class="o">&lt;</span> <span class="nv">$input</span><span class="o">-&gt;</span><span class="na">getOption</span><span class="p">(</span><span class="s1">'iterations'</span><span class="p">);</span> <span class="nv">$i</span><span class="o">++</span><span class="p">)</span> <span class="p">{</span>
    <span class="nv">$output</span><span class="o">-&gt;</span><span class="na">writeln</span><span class="p">(</span><span class="nv">$text</span><span class="p">);</span>
<span class="p">}</span>
	  </pre></div>
	</div>
	<p>Now, when you run the task, you can optionally specify a <tt class="docutils literal"><span class="pre">--iterations</span></tt>
	  flag:</p>
	<div class="highlight-bash"><div class="highlight"><pre><span class="nv">$ </span>php app/console demo:greet Fabien

<span class="nv">$ </span>php app/console demo:greet Fabien --iterations<span class="o">=</span>5
	  </pre></div>
	</div>
	<p>The first example will only print once, since <tt class="docutils literal"><span class="pre">iterations</span></tt> is empty and
	  defaults to <tt class="docutils literal"><span class="pre">1</span></tt> (the last argument of <tt class="docutils literal"><span class="pre">addOption</span></tt>). The second example
	  will print five times.</p>
	<p>Recall that options don't care about their order. So, either of the following
	  will work:</p>
	<div class="highlight-bash"><div class="highlight"><pre><span class="nv">$ </span>php app/console demo:greet Fabien --iterations<span class="o">=</span>5 --yell
<span class="nv">$ </span>php app/console demo:greet Fabien --yell --iterations<span class="o">=</span>5
	  </pre></div>
	</div>
      </div>
      <div class="section" id="testing-commands">
	<h2>Testing Commands<a class="headerlink" href="#testing-commands" title="Permalink to this headline">¶</a></h2>
	<p>Symfony2 provides several tools to help you test your commands. The most
	  useful one is the <tt class="docutils literal"><a class="reference external" href="http://api.symfony.com/2.0/Symfony/Component/Console/Tester/CommandTester.html" title="Symfony\Component\Console\Tester\CommandTester"><span class="pre">CommandTester</span></a></tt>
	  class. It uses special input and output classes to ease testing without a real
	  console:</p>
	<div class="highlight-php"><div class="highlight"><pre><span class="k">use</span> <span class="nx">Symfony\Component\Console\Tester\CommandTester</span><span class="p">;</span>
<span class="k">use</span> <span class="nx">Symfony\Bundle\FrameworkBundle\Console\Application</span><span class="p">;</span>

<span class="k">class</span> <span class="nc">ListCommandTest</span> <span class="k">extends</span> <span class="nx">\PHPUnit_Framework_TestCase</span>
<span class="p">{</span>
    <span class="k">public</span> <span class="k">function</span> <span class="nf">testExecute</span><span class="p">()</span>
    <span class="p">{</span>
        <span class="c1">// mock the Kernel or create one depending on your needs</span>
        <span class="nv">$application</span> <span class="o">=</span> <span class="k">new</span> <span class="nx">Application</span><span class="p">(</span><span class="nv">$kernel</span><span class="p">);</span>

        <span class="nv">$command</span> <span class="o">=</span> <span class="nv">$application</span><span class="o">-&gt;</span><span class="na">find</span><span class="p">(</span><span class="s1">'demo:greet'</span><span class="p">);</span>
        <span class="nv">$commandTester</span> <span class="o">=</span> <span class="k">new</span> <span class="nx">CommandTester</span><span class="p">(</span><span class="nv">$command</span><span class="p">);</span>
        <span class="nv">$commandTester</span><span class="o">-&gt;</span><span class="na">execute</span><span class="p">(</span><span class="k">array</span><span class="p">(</span><span class="s1">'command'</span> <span class="o">=&gt;</span> <span class="nv">$command</span><span class="o">-&gt;</span><span class="na">getFullName</span><span class="p">()));</span>

        <span class="nv">$this</span><span class="o">-&gt;</span><span class="na">assertRegExp</span><span class="p">(</span><span class="s1">'/.../'</span><span class="p">,</span> <span class="nv">$commandTester</span><span class="o">-&gt;</span><span class="na">getDisplay</span><span class="p">());</span>

        <span class="c1">// ...</span>
    <span class="p">}</span>
<span class="p">}</span>
	  </pre></div>
	</div>
	<p>The <tt class="docutils literal"><a class="reference external" href="http://api.symfony.com/2.0/Symfony/Component/Console/Tester/CommandTester.html#getDisplay()" title="Symfony\Component\Console\Tester\CommandTester::getDisplay()"><span class="pre">getDisplay()</span></a></tt>
	  method returns what would have been displayed during a normal call from the
	  console.</p>
	<div class="admonition-wrapper">
	  <div class="tip"></div><div class="admonition admonition-tip"><p class="first admonition-title">Tip</p>
	    <p class="last">You can also test a whole console application by using
	      <tt class="docutils literal"><a class="reference external" href="http://api.symfony.com/2.0/Symfony/Component/Console/Tester/ApplicationTester.html" title="Symfony\Component\Console\Tester\ApplicationTester"><span class="pre">ApplicationTester</span></a></tt>.</p>
	</div></div>
      </div>
      <div class="section" id="getting-services-from-the-service-container">
	<h2>Getting Services from the Service Container<a class="headerlink" href="#getting-services-from-the-service-container" title="Permalink to this headline">¶</a></h2>
	<p>By using <tt class="docutils literal"><span class="pre">Symfony\Bundle\FrameworkBundle\Command\Command</span></tt> as the base class
	  for the command (instead of the more basic
	  <tt class="docutils literal"><span class="pre">Symfony\Component\Console\Command\Command</span></tt>), you have access to the service
	  container. In other words, you have access to any configured service. For
	  example, you could easily extend the task to be translatable:</p>
	<div class="highlight-php"><div class="highlight"><pre><span class="k">protected</span> <span class="k">function</span> <span class="nf">execute</span><span class="p">(</span><span class="nx">InputInterface</span> <span class="nv">$input</span><span class="p">,</span> <span class="nx">OutputInterface</span> <span class="nv">$output</span><span class="p">)</span>
<span class="p">{</span>
    <span class="nv">$name</span> <span class="o">=</span> <span class="nv">$input</span><span class="o">-&gt;</span><span class="na">getArgument</span><span class="p">(</span><span class="s1">'name'</span><span class="p">);</span>
    <span class="nv">$translator</span> <span class="o">=</span> <span class="nv">$this</span><span class="o">-&gt;</span><span class="na">container</span><span class="o">-&gt;</span><span class="na">get</span><span class="p">(</span><span class="s1">'translator'</span><span class="p">);</span>
    <span class="k">if</span> <span class="p">(</span><span class="nv">$name</span><span class="p">)</span> <span class="p">{</span>
        <span class="nv">$output</span><span class="o">-&gt;</span><span class="na">writeln</span><span class="p">(</span><span class="nv">$translator</span><span class="o">-&gt;</span><span class="na">trans</span><span class="p">(</span><span class="s1">'Hello %name%!'</span><span class="p">,</span> <span class="k">array</span><span class="p">(</span><span class="s1">'%name%'</span> <span class="o">=&gt;</span> <span class="nv">$name</span><span class="p">)));</span>
    <span class="p">}</span> <span class="k">else</span> <span class="p">{</span>
        <span class="nv">$output</span><span class="o">-&gt;</span><span class="na">writeln</span><span class="p">(</span><span class="nv">$translator</span><span class="o">-&gt;</span><span class="na">trans</span><span class="p">(</span><span class="s1">'Hello!'</span><span class="p">));</span>
    <span class="p">}</span>
<span class="p">}</span>
	  </pre></div>
	</div>
      </div>
      <div class="section" id="calling-an-existing-command">
	<h2>Calling an existing Command<a class="headerlink" href="#calling-an-existing-command" title="Permalink to this headline">¶</a></h2>
	<p>If a command depends on another one being run before it, instead of asking the
	  user to remember the order of execution, you can call it directly yourself.
	  This is also useful if you want to create a "meta" command that just runs a
	  bunch of other commands (for instance, all commands that need to be run when
	  the project's code has changed on the production servers: clearing the cache,
	  generating Doctrine2 proxies, dumping Assetic assets, ...).</p>
	<p>Calling a command from another one is straightforward:</p>
	<div class="highlight-php"><div class="highlight"><pre><span class="k">protected</span> <span class="k">function</span> <span class="nf">execute</span><span class="p">(</span><span class="nx">InputInterface</span> <span class="nv">$input</span><span class="p">,</span> <span class="nx">OutputInterface</span> <span class="nv">$output</span><span class="p">)</span>
<span class="p">{</span>
    <span class="nv">$command</span> <span class="o">=</span> <span class="nv">$this</span><span class="o">-&gt;</span><span class="na">getApplication</span><span class="p">()</span><span class="o">-&gt;</span><span class="na">find</span><span class="p">(</span><span class="s1">'demo:greet'</span><span class="p">);</span>

    <span class="nv">$arguments</span> <span class="o">=</span> <span class="k">array</span><span class="p">(</span>
        <span class="s1">'name'</span>   <span class="o">=&gt;</span> <span class="s1">'Fabien'</span><span class="p">,</span>
        <span class="s1">'--yell'</span> <span class="o">=&gt;</span> <span class="k">true</span><span class="p">,</span>
    <span class="p">);</span>

    <span class="nv">$input</span> <span class="o">=</span> <span class="k">new</span> <span class="nx">ArrayInput</span><span class="p">(</span><span class="nv">$arguments</span><span class="p">);</span>
    <span class="nv">$returnCode</span> <span class="o">=</span> <span class="nv">$command</span><span class="o">-&gt;</span><span class="na">run</span><span class="p">(</span><span class="nv">$input</span><span class="p">,</span> <span class="nv">$output</span><span class="p">);</span>

    <span class="c1">// ...</span>
<span class="p">}</span>
	  </pre></div>
	</div>
	<p>First, you <tt class="docutils literal"><a class="reference external" href="http://api.symfony.com/2.0/Symfony/Component/Console/Command/Command.html#find()" title="Symfony\Component\Console\Command\Command::find()"><span class="pre">find()</span></a></tt> the
	  command you want to execute by passing the command name.</p>
	<p>Then, you need to create a new
	  <tt class="docutils literal"><a class="reference external" href="http://api.symfony.com/2.0/Symfony/Component/Console/Input/ArrayInput.html" title="Symfony\Component\Console\Input\ArrayInput"><span class="pre">ArrayInput</span></a></tt> with the arguments and
	  options you want to pass to the command.</p>
	<p>Eventually, calling the <tt class="docutils literal"><span class="pre">run()</span></tt> method actually executes the command and
	  returns the returned code from the command (<tt class="docutils literal"><span class="pre">0</span></tt> if everything went fine, any
	  other integer otherwise).</p>
	<div class="admonition-wrapper">
	  <div class="note"></div><div class="admonition admonition-note"><p class="first admonition-title">Note</p>
	    <p class="last">Most of the time, calling a command from code that is not executed on the
	      command line is not a good idea for several reasons. First, the command's
	      output is optimized for the console. But more important, you can think of
	      a command as being like a controller; it should use the model to do
	      something and display feedback to the user. So, instead of calling a
	      command from the Web, refactor your code and move the logic to a new
	      class.</p>
	</div></div>
      </div>
    </div>


    

  </div>

  <div class="navigation">
    <a accesskey="P" title="How to locate Files" href="tools/finder.html">
      «&nbsp;How to locate Files
    </a><span class="separator">|</span>
    <a accesskey="N" title="How to optimize your development Environment for debugging" href="debugging.html">
      How to optimize your development Environment for debugging&nbsp;»
    </a>
  </div>

  <div class="box_hr"><hr></div>

</div>
