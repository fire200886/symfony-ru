<?php include(__DIR__.'/../../_doc.php')?>
<div class="column_02">

  <div class="box_title">
    <h1 class="title_01">How to extend a Class without using Inheritance</h1>
  </div>
  
  

  <div class="box_article doc_page">

    
    
    <div class="section" id="how-to-extend-a-class-without-using-inheritance">
      <span id="index-0"></span><h1>How to extend a Class without using Inheritance<a class="headerlink" href="#how-to-extend-a-class-without-using-inheritance" title="Permalink to this headline">¶</a></h1>
      <p>To allow multiple classes to add methods to another one, you can define the
	magic <tt class="docutils literal"><span class="pre">__call()</span></tt> method in the class you want to be extended like this:</p>
      <div class="highlight-php"><div class="highlight"><pre><span class="k">class</span> <span class="nc">Foo</span>
<span class="p">{</span>
    <span class="c1">// ...</span>

    <span class="k">public</span> <span class="k">function</span> <span class="nf">__call</span><span class="p">(</span><span class="nv">$method</span><span class="p">,</span> <span class="nv">$arguments</span><span class="p">)</span>
    <span class="p">{</span>
        <span class="c1">// create an event named 'foo.method_is_not_found'</span>
        <span class="nv">$event</span> <span class="o">=</span> <span class="k">new</span> <span class="nx">HandleUndefinedMethodEvent</span><span class="p">(</span><span class="nv">$this</span><span class="p">,</span> <span class="nv">$method</span><span class="p">,</span> <span class="nv">$arguments</span><span class="p">);</span>
        <span class="nv">$this</span><span class="o">-&gt;</span><span class="na">dispatcher</span><span class="o">-&gt;</span><span class="na">dispatch</span><span class="p">(</span><span class="nv">$this</span><span class="p">,</span> <span class="s1">'foo.method_is_not_found'</span><span class="p">,</span> <span class="nv">$event</span><span class="p">);</span>

        <span class="c1">// no listener was able to process the event? The method does not exist</span>
        <span class="k">if</span> <span class="p">(</span><span class="o">!</span><span class="nv">$event</span><span class="o">-&gt;</span><span class="na">isProcessed</span><span class="p">())</span> <span class="p">{</span>
            <span class="k">throw</span> <span class="k">new</span> <span class="nx">\Exception</span><span class="p">(</span><span class="nb">sprintf</span><span class="p">(</span><span class="s1">'Call to undefined method %s::%s.'</span><span class="p">,</span> <span class="nb">get_class</span><span class="p">(</span><span class="nv">$this</span><span class="p">),</span> <span class="nv">$method</span><span class="p">));</span>
        <span class="p">}</span>

        <span class="c1">// return the listener returned value</span>
        <span class="k">return</span> <span class="nv">$event</span><span class="o">-&gt;</span><span class="na">getReturnValue</span><span class="p">();</span>
    <span class="p">}</span>
<span class="p">}</span>
	</pre></div>
      </div>
      <p>This uses a special <tt class="docutils literal"><span class="pre">HandleUndefinedMethodEvent</span></tt> that should also be
	created. This is a generic class that could be reused each time you need to
	use this pattern of class extension:</p>
      <div class="highlight-php"><div class="highlight"><pre><span class="k">use</span> <span class="nx">Symfony\Component\EventDispatcher\Event</span><span class="p">;</span>

<span class="k">class</span> <span class="nc">HandleUndefinedMethodEvent</span> <span class="k">extends</span> <span class="nx">Event</span>
<span class="p">{</span>
    <span class="k">protected</span> <span class="nv">$subject</span><span class="p">;</span>
    <span class="k">protected</span> <span class="nv">$method</span><span class="p">;</span>
    <span class="k">protected</span> <span class="nv">$arguments</span><span class="p">;</span>
    <span class="k">protected</span> <span class="nv">$returnValue</span><span class="p">;</span>
    <span class="k">protected</span> <span class="nv">$isProcessed</span> <span class="o">=</span> <span class="k">false</span><span class="p">;</span>

    <span class="k">public</span> <span class="k">function</span> <span class="nf">__construct</span><span class="p">(</span><span class="nv">$subject</span><span class="p">,</span> <span class="nv">$method</span><span class="p">,</span> <span class="nv">$arguments</span><span class="p">)</span>
    <span class="p">{</span>
        <span class="nv">$this</span><span class="o">-&gt;</span><span class="na">subject</span> <span class="o">=</span> <span class="nv">$subject</span><span class="p">;</span>
        <span class="nv">$this</span><span class="o">-&gt;</span><span class="na">method</span> <span class="o">=</span> <span class="nv">$method</span><span class="p">;</span>
        <span class="nv">$this</span><span class="o">-&gt;</span><span class="na">arguments</span> <span class="o">=</span> <span class="nv">$arguments</span><span class="p">;</span>
    <span class="p">}</span>

    <span class="k">public</span> <span class="k">function</span> <span class="nf">getSubject</span><span class="p">()</span>
    <span class="p">{</span>
        <span class="k">return</span> <span class="nv">$this</span><span class="o">-&gt;</span><span class="na">subject</span><span class="p">;</span>
    <span class="p">}</span>

    <span class="k">public</span> <span class="k">function</span> <span class="nf">getMethod</span><span class="p">()</span>
    <span class="p">{</span>
        <span class="k">return</span> <span class="nv">$this</span><span class="o">-&gt;</span><span class="na">method</span><span class="p">;</span>
    <span class="p">}</span>

    <span class="k">public</span> <span class="k">function</span> <span class="nf">getArguments</span><span class="p">()</span>
    <span class="p">{</span>
        <span class="k">return</span> <span class="nv">$this</span><span class="o">-&gt;</span><span class="na">arguments</span><span class="p">;</span>
    <span class="p">}</span>

    <span class="sd">/**</span>
<span class="sd">     * Sets the value to return and stops other listeners from being notified</span>
<span class="sd">     */</span>
    <span class="k">public</span> <span class="k">function</span> <span class="nf">setReturnValue</span><span class="p">(</span><span class="nv">$val</span><span class="p">)</span>
    <span class="p">{</span>
        <span class="nv">$this</span><span class="o">-&gt;</span><span class="na">returnValue</span> <span class="o">=</span> <span class="nv">$val</span><span class="p">;</span>
        <span class="nv">$this</span><span class="o">-&gt;</span><span class="na">isProcessed</span> <span class="o">=</span> <span class="k">true</span><span class="p">;</span>
        <span class="nv">$this</span><span class="o">-&gt;</span><span class="na">stopPropagation</span><span class="p">();</span>
    <span class="p">}</span>

    <span class="k">public</span> <span class="k">function</span> <span class="nf">getReturnValue</span><span class="p">(</span><span class="nv">$val</span><span class="p">)</span>
    <span class="p">{</span>
        <span class="k">return</span> <span class="nv">$this</span><span class="o">-&gt;</span><span class="na">returnValue</span><span class="p">;</span>
    <span class="p">}</span>

    <span class="k">public</span> <span class="k">function</span> <span class="nf">isProcessed</span><span class="p">()</span>
    <span class="p">{</span>
        <span class="k">return</span> <span class="nv">$this</span><span class="o">-&gt;</span><span class="na">isProcessed</span><span class="p">;</span>
    <span class="p">}</span>
<span class="p">}</span>
	</pre></div>
      </div>
      <p>Next, create a class that will listen to the <tt class="docutils literal"><span class="pre">foo.method_is_not_found</span></tt> event
	and <em>add</em> the method <tt class="docutils literal"><span class="pre">bar()</span></tt>:</p>
      <div class="highlight-php"><div class="highlight"><pre><span class="k">class</span> <span class="nc">Bar</span>
<span class="p">{</span>
    <span class="k">public</span> <span class="k">function</span> <span class="nf">onFooMethodIsNotFound</span><span class="p">(</span><span class="nx">HandleUndefinedMethodEvent</span> <span class="nv">$event</span><span class="p">)</span>
    <span class="p">{</span>
        <span class="c1">// we only want to respond to the calls to the 'bar' method</span>
        <span class="k">if</span> <span class="p">(</span><span class="s1">'bar'</span> <span class="o">!=</span> <span class="nv">$event</span><span class="o">-&gt;</span><span class="na">getMethod</span><span class="p">())</span> <span class="p">{</span>
            <span class="c1">// allow another listener to take care of this unknown method</span>
            <span class="k">return</span><span class="p">;</span>
        <span class="p">}</span>

        <span class="c1">// the subject object (the foo instance)</span>
        <span class="nv">$foo</span> <span class="o">=</span> <span class="nv">$event</span><span class="o">-&gt;</span><span class="na">getSubject</span><span class="p">();</span>

        <span class="c1">// the bar method arguments</span>
        <span class="nv">$arguments</span> <span class="o">=</span> <span class="nv">$event</span><span class="o">-&gt;</span><span class="na">getArguments</span><span class="p">();</span>

        <span class="c1">// do something</span>
        <span class="c1">// ...</span>

        <span class="c1">// set the return value</span>
        <span class="nv">$event</span><span class="o">-&gt;</span><span class="na">setReturnValue</span><span class="p">(</span><span class="nv">$someValue</span><span class="p">);</span>
    <span class="p">}</span>
<span class="p">}</span>
	</pre></div>
      </div>
      <p>Finally, add the new <tt class="docutils literal"><span class="pre">bar</span></tt> method to the <tt class="docutils literal"><span class="pre">Foo</span></tt> class by register an
	instance of <tt class="docutils literal"><span class="pre">Bar</span></tt> with the <tt class="docutils literal"><span class="pre">foo.method_is_not_found</span></tt> event:</p>
      <div class="highlight-php"><div class="highlight"><pre><span class="nv">$bar</span> <span class="o">=</span> <span class="k">new</span> <span class="nx">Bar</span><span class="p">();</span>
<span class="nv">$dispatcher</span><span class="o">-&gt;</span><span class="na">addListener</span><span class="p">(</span><span class="s1">'foo.method_is_not_found'</span><span class="p">,</span> <span class="nv">$bar</span><span class="p">);</span>
	</pre></div>
      </div>
    </div>


    

  </div>

  <div class="navigation">
    <a accesskey="P" title="How to use Monolog to write Logs" href="../logging/monolog.html">
      «&nbsp;How to use Monolog to write Logs
    </a><span class="separator">|</span>
    <a accesskey="N" title="How to customize a Method Behavior without using Inheritance" href="method_behavior.html">
      How to customize a Method Behavior without using Inheritance&nbsp;»
    </a>
  </div>

  <div class="box_hr"><hr></div>

</div>
