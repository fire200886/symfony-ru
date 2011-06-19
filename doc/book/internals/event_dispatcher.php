<?php include(__DIR__.'/../../_doc.php')?>
<div class="column_02">

  <div class="box_title">
    <h1 class="title_01">The Event Dispatcher</h1>
  </div>
  
  

  <div class="box_article doc_page">

    
    
    <div class="section" id="the-event-dispatcher">
      <span id="index-0"></span><h1>The Event Dispatcher<a class="headerlink" href="#the-event-dispatcher" title="Permalink to this headline">¶</a></h1>
      <p>Objected Oriented code has gone a long way to ensuring code extensibility. By
	creating classes that have well defined responsibilities, your code becomes
	more flexible and a developer can extend them with subclasses to modify their
	behaviors. But if he wants to share his changes with other developers who have
	also made their own subclasses, code inheritance is moot.</p>
      <p>Consider the real-world example where you want to provide a plugin system for
	your project. A plugin should be able to add methods, or do something before
	or after a method is executed, without interfering with other plugins. This is
	not an easy problem to solve with single inheritance, and multiple inheritance
	(were it possible with PHP) has its own drawbacks.</p>
      <p>The Symfony2 Event Dispatcher implements the <a class="reference external" href="http://en.wikipedia.org/wiki/Observer_pattern">Observer</a> pattern in a simple
	and effective way to make all these things possible and to make your projects
	truly extensible.</p>
      <p>Take a simple example from the <a class="reference external" href="https://github.com/symfony/HttpKernel">Symfony2 HttpKernel component</a>. Once a
	<tt class="docutils literal"><span class="pre">Response</span></tt> object has been created, it may be useful to allow other elements
	in the system to modify it (e.g. add some cache headers) before it's actually
	used. To make this possible, the Symfony2 kernel throws an event -
	<tt class="docutils literal"><span class="pre">core.response</span></tt>. Here's how it work:</p>
      <ul class="simple">
	<li>A <em>listener</em> (PHP object) tells a central <em>dispatcher</em> object that it wants
	  to listen to the <tt class="docutils literal"><span class="pre">core.response</span></tt> event;</li>
	<li>At some point, the Symfony2 kernel tells the <em>dispatcher</em> object to dispatch
	  the <tt class="docutils literal"><span class="pre">core.response</span></tt> event, passing with it an <tt class="docutils literal"><span class="pre">Event</span></tt> object that has
	  access to the <tt class="docutils literal"><span class="pre">Response</span></tt> object;</li>
	<li>The dispatcher notifies (i.e. calls a method on) all listeners of the
	  <tt class="docutils literal"><span class="pre">core.response</span></tt> event, allowing each of them to make any modification to
	  the <tt class="docutils literal"><span class="pre">Response</span></tt> object.</li>
      </ul>
      <div class="section" id="events">
	<span id="index-1"></span><h2>Events<a class="headerlink" href="#events" title="Permalink to this headline">¶</a></h2>
	<p>When an event is dispatched, it's identified by a unique name (e.g.
	  <tt class="docutils literal"><span class="pre">core.response</span></tt>), which any number of listeners might be listening to. A
	  <tt class="docutils literal"><a class="reference external" href="http://api.symfony.com/2.0/Symfony/Component/EventDispatcher/Event.html" title="Symfony\Component\EventDispatcher\Event"><span class="pre">Event</span></a></tt> instance is also created
	  and passed to all of the listeners. As you'll see later, the <tt class="docutils literal"><span class="pre">Event</span></tt> object
	  itself often contains data about the event being dispatched.</p>
	<div class="section" id="naming-conventions">
	  <span id="index-2"></span><h3>Naming Conventions<a class="headerlink" href="#naming-conventions" title="Permalink to this headline">¶</a></h3>
	  <p>The unique event name can be any string, but optionally follows a few simple
	    naming conventions:</p>
	  <ul class="simple">
	    <li>use only lowercase letters, numbers, dots (<tt class="docutils literal"><span class="pre">.</span></tt>), and underscores (<tt class="docutils literal"><span class="pre">_</span></tt>);</li>
	    <li>prefix names with a namespace followed by a dot (e.g. <tt class="docutils literal"><span class="pre">core.</span></tt>);</li>
	    <li>end names with a verb that indicates what action is being taken (e.g.
	      <tt class="docutils literal"><span class="pre">request</span></tt>).</li>
	  </ul>
	  <p>Here are some examples of good event names:</p>
	  <ul class="simple">
	    <li><tt class="docutils literal"><span class="pre">core.response</span></tt></li>
	    <li><tt class="docutils literal"><span class="pre">form.pre_set_data</span></tt></li>
	  </ul>
	</div>
	<div class="section" id="event-names-and-event-objects">
	  <span id="index-3"></span><h3>Event Names and Event Objects<a class="headerlink" href="#event-names-and-event-objects" title="Permalink to this headline">¶</a></h3>
	  <p>When the dispatcher notifies listeners, it passes an actual <tt class="docutils literal"><span class="pre">Event</span></tt> object
	    to those listeners. The base <tt class="docutils literal"><span class="pre">Event</span></tt> class is very simple: it contains a
	    method for stopping <a class="reference internal" href="#event-dispatcher-event-propagation"><em>event
		propagation</em></a>, but not much else.</p>
	  <p>Often times, data about a specific event needs to be passed along with the
	    <tt class="docutils literal"><span class="pre">Event</span></tt> object so that the listeners have needed information. In the case of
	    the <tt class="docutils literal"><span class="pre">core.response</span></tt> event, the <tt class="docutils literal"><span class="pre">Event</span></tt> object that's created and passed to
	    each listener is actually of type
	    <tt class="docutils literal"><a class="reference external" href="http://api.symfony.com/2.0/Symfony/Component/HttpKernel/Event/FilterResponseEvent.html" title="Symfony\Component\HttpKernel\Event\FilterResponseEvent"><span class="pre">FilterResponseEvent</span></a></tt>, a
	    subclass of the base <tt class="docutils literal"><span class="pre">Event</span></tt> object. This class contains methods such as
	    <tt class="docutils literal"><span class="pre">getResponse</span></tt> and <tt class="docutils literal"><span class="pre">setResponse</span></tt>, allowing listeners to get or even replace
	    the <tt class="docutils literal"><span class="pre">Response</span></tt> object.</p>
	  <p>The moral of the story is this: when creating a listener to an event, the
	    <tt class="docutils literal"><span class="pre">Event</span></tt> object that's passed to the listener may be a special subclass that
	    has additional methods for retrieving information from and responding to the
	    event.</p>
	</div>
      </div>
      <div class="section" id="the-dispatcher">
	<h2>The Dispatcher<a class="headerlink" href="#the-dispatcher" title="Permalink to this headline">¶</a></h2>
	<p>The dispatcher is the central object of the event dispatcher system. In
	  general, a single dispatcher is created, which maintains a register of
	  listeners. When an event is dispatched via the dispatcher, it notifies all
	  listeners registered with that event.</p>
	<div class="highlight-php"><div class="highlight"><pre><span class="k">use</span> <span class="nx">Symfony\Component\EventDispatcher\EventDispatcher</span><span class="p">;</span>

<span class="nv">$dispatcher</span> <span class="o">=</span> <span class="k">new</span> <span class="nx">EventDispatcher</span><span class="p">();</span>
	  </pre></div>
	</div>
      </div>
      <div class="section" id="connecting-listeners">
	<span id="index-4"></span><h2>Connecting Listeners<a class="headerlink" href="#connecting-listeners" title="Permalink to this headline">¶</a></h2>
	<p>To take advantage of an existing event, you need to connect a listener to the
	  dispatcher so that it can be notified when the event is dispatched. A call to
	  the dispatcher <tt class="docutils literal"><span class="pre">addListener()</span></tt> method associates any valid PHP callable to
	  an event:</p>
	<div class="highlight-php"><div class="highlight"><pre><span class="nv">$listener</span> <span class="o">=</span> <span class="k">new</span> <span class="nx">AcmeListener</span><span class="p">();</span>
<span class="nv">$dispatcher</span><span class="o">-&gt;</span><span class="na">addListener</span><span class="p">(</span><span class="s1">'foo.action'</span><span class="p">,</span> <span class="k">array</span><span class="p">(</span><span class="nv">$listener</span><span class="p">,</span> <span class="s1">'onFooAction'</span><span class="p">));</span>
	  </pre></div>
	</div>
	<p>The <tt class="docutils literal"><span class="pre">addListener()</span></tt> method takes up to three arguments:</p>
	<ul class="simple">
	  <li>The event name (string) that this listener wants to listen to;</li>
	  <li>A PHP callable that will be notified when an event is thrown that it listens
	    to;</li>
	  <li>An optional priority integer (higher equals more important) that determines
	    when a listener is triggered versus other listeners (defaults to <tt class="docutils literal"><span class="pre">0</span></tt>). If
	    two listeners have the same priority, they are executed in the order that
	    they were added to the dispatcher.</li>
	</ul>
	<div class="admonition-wrapper">
	  <div class="note"></div><div class="admonition admonition-note"><p class="first admonition-title">Note</p>
	    <p>A <a href="#id1"><span class="problematic" id="id2">`PHP callable`_</span></a> is a PHP variable that can be used by the
	      <tt class="docutils literal"><span class="pre">call_user_func()</span></tt> function and returns <tt class="docutils literal"><span class="pre">true</span></tt> when passed to the
	      <tt class="docutils literal"><span class="pre">is_callable()</span></tt> function. It can be a <tt class="docutils literal"><span class="pre">\Closure</span></tt> instance, a string
	      representing a function, or an array representing an object method or a
	      class method.</p>
	    <p>So far, you've seen how PHP objects can be registered as listeners. You
	      can also register PHP <a class="reference external" href="http://php.net/manual/en/functions.anonymous.php">Closures</a> as event listeners:</p>
	    <div class="last highlight-php"><div class="highlight"><pre><span class="k">use</span> <span class="nx">Symfony\Component\EventDispatcher\Event</span><span class="p">;</span>

<span class="nv">$dispatcher</span><span class="o">-&gt;</span><span class="na">addListener</span><span class="p">(</span><span class="s1">'foo.action'</span><span class="p">,</span> <span class="k">function</span> <span class="p">(</span><span class="nx">Event</span> <span class="nv">$event</span><span class="p">)</span> <span class="p">{</span>
    <span class="c1">// will be executed when the foo.action event is dispatched</span>
<span class="p">});</span>
	      </pre></div>
	    </div>
	</div></div>
	<p>Once a listener is registered with the dispatcher, it waits until the event is
	  notified. In the above example, when the <tt class="docutils literal"><span class="pre">foo.action</span></tt> event is dispatched,
	  the dispatcher calls the <tt class="docutils literal"><span class="pre">AcmeListener::onFooAction</span></tt> method and passes the
	  <tt class="docutils literal"><span class="pre">Event</span></tt> object as the single argument:</p>
	<div class="highlight-php"><div class="highlight"><pre><span class="k">use</span> <span class="nx">Symfony\Component\EventDispatcher\Event</span><span class="p">;</span>

<span class="k">class</span> <span class="nc">AcmeListener</span>
<span class="p">{</span>
    <span class="c1">// ...</span>

    <span class="k">public</span> <span class="k">function</span> <span class="nf">onFooAction</span><span class="p">(</span><span class="nx">Event</span> <span class="nv">$event</span><span class="p">)</span>
    <span class="p">{</span>
        <span class="c1">// do something</span>
    <span class="p">}</span>
<span class="p">}</span>
	  </pre></div>
	</div>
	<div class="admonition-wrapper">
	  <div class="tip"></div><div class="admonition admonition-tip"><p class="first admonition-title">Tip</p>
	    <p class="last">If you use the Symfony2 MVC framework, listeners can be registered via
	      your <a class="reference internal" href="../../reference/dic_tags.html#dic-tags-kernel-listener"><em>configuration</em></a>. As an added bonus,
	      the listener objects are instantiated only when needed.</p>
	</div></div>
	<p>In many cases, a special <tt class="docutils literal"><span class="pre">Event</span></tt> subclass that's specific to the given event
	  is passed to the listener. This gives the listener access to special
	  information about the event. Check the documentation or implementation of each
	  event to determine the exact <tt class="docutils literal"><span class="pre">Symfony\Component\EventDispatcher\Event</span></tt>
	  instance that's being passed. For example, the <tt class="docutils literal"><span class="pre">core.event</span></tt> event passes an
	  instance of <tt class="docutils literal"><span class="pre">Symfony\Component\HttpKernel\Event\FilterResponseEvent</span></tt>:</p>
	<div class="highlight-php"><div class="highlight"><pre><span class="k">use</span> <span class="nx">Symfony\Component\HttpKernel\Event\FilterResponseEvent</span>

<span class="k">public</span> <span class="k">function</span> <span class="nf">onCoreResponse</span><span class="p">(</span><span class="nx">FilterResponseEvent</span> <span class="nv">$event</span><span class="p">)</span>
<span class="p">{</span>
    <span class="nv">$response</span> <span class="o">=</span> <span class="nv">$event</span><span class="o">-&gt;</span><span class="na">getResponse</span><span class="p">();</span>
    <span class="nv">$request</span> <span class="o">=</span> <span class="nv">$event</span><span class="o">-&gt;</span><span class="na">getRequest</span><span class="p">();</span>

    <span class="c1">// ...</span>
<span class="p">}</span>
	  </pre></div>
	</div>
	<span class="target" id="event-dispatcher-closures-as-listeners"></span></div>
      <div class="section" id="creating-and-dispatching-an-event">
	<span id="index-5"></span><h2>Creating and Dispatching an Event<a class="headerlink" href="#creating-and-dispatching-an-event" title="Permalink to this headline">¶</a></h2>
	<p>In addition to registering listeners with existing events, you can create and
	  throw your own events. This is useful when creating third-party libraries and
	  also when you want to keep different components of your own system flexible
	  and decoupled.</p>
	<div class="section" id="the-static-events-class">
	  <h3>The Static <tt class="docutils literal"><span class="pre">Events</span></tt> Class<a class="headerlink" href="#the-static-events-class" title="Permalink to this headline">¶</a></h3>
	  <p>Suppose you want to create a new Event - <tt class="docutils literal"><span class="pre">store.order</span></tt> - that is dispatched
	    each time an order is created inside your application. To keep things
	    organized, start by creating a <tt class="docutils literal"><span class="pre">StoreEvents</span></tt> class inside your application
	    that serves to define and document your event:</p>
	  <div class="highlight-php"><div class="highlight"><pre><span class="k">namespace</span> <span class="nx">Acme\StoreBundle</span><span class="p">;</span>

<span class="k">final</span> <span class="k">class</span> <span class="nc">StoreEvents</span>
<span class="p">{</span>
    <span class="sd">/**</span>
<span class="sd">     * The store.order event is thrown each time an order is created</span>
<span class="sd">     * in the system.</span>
<span class="sd">     *</span>
<span class="sd">     * The event listener receives an Acme\StoreBundle\Event\FilterOrderEvent</span>
<span class="sd">     * instance.</span>
<span class="sd">     *</span>
<span class="sd">     * @var string</span>
<span class="sd">     */</span>
    <span class="k">const</span> <span class="no">onStoreOrder</span> <span class="o">=</span> <span class="s1">'store.order'</span><span class="p">;</span>
<span class="p">}</span>
	    </pre></div>
	  </div>
	  <p>Notice that this class doesn't actually <em>do</em> anything. The purpose of the
	    <tt class="docutils literal"><span class="pre">StoreEvents</span></tt> class is just to be a location where information about common
	    events can be centralized. Notice also that a special <tt class="docutils literal"><span class="pre">FilterOrderEvent</span></tt>
	    class will be passed to each listener of this event.</p>
	</div>
	<div class="section" id="creating-an-event-object">
	  <h3>Creating an Event object<a class="headerlink" href="#creating-an-event-object" title="Permalink to this headline">¶</a></h3>
	  <p>Later, when you dispatch this new event, you'll create an <tt class="docutils literal"><span class="pre">Event</span></tt> instance
	    and pass it to the dispatcher. The dispatcher then passes this same instance
	    to each of the listeners of the event. If you don't need to pass any
	    information to your listeners, you can use the default
	    <tt class="docutils literal"><span class="pre">Symfony\Component\EventDispatcher\Event</span></tt> class. Most of the time, however,
	    you <em>will</em> need to pass information about the event to each listener. To
	    accomplish this, you'll create a new class that extends
	    <tt class="docutils literal"><span class="pre">Symfony\Component\EventDispatcher\Event</span></tt>.</p>
	  <p>In this example, each listener will need access to some pretend <tt class="docutils literal"><span class="pre">Order</span></tt>
	    object. Create an <tt class="docutils literal"><span class="pre">Event</span></tt> class that makes this possible:</p>
	  <div class="highlight-php"><div class="highlight"><pre><span class="k">namespace</span> <span class="nx">Acme\StoreBundle\Event</span><span class="p">;</span>

<span class="k">use</span> <span class="nx">Symfony\Component\EventDispatcher\Event</span><span class="p">;</span>
<span class="k">use</span> <span class="nx">Acme\StoreBundle\Order</span><span class="p">;</span>

<span class="k">class</span> <span class="nc">FilterOrderEvent</span> <span class="k">extends</span> <span class="nx">Event</span>
<span class="p">{</span>
    <span class="k">protected</span> <span class="nv">$order</span><span class="p">;</span>

    <span class="k">public</span> <span class="k">function</span> <span class="nf">__construct</span><span class="p">(</span><span class="nx">Order</span> <span class="nv">$order</span><span class="p">)</span>
    <span class="p">{</span>
        <span class="nv">$this</span><span class="o">-&gt;</span><span class="na">order</span> <span class="o">=</span> <span class="nv">$order</span><span class="p">;</span>
    <span class="p">}</span>

    <span class="k">public</span> <span class="k">function</span> <span class="nf">getOrder</span><span class="p">()</span>
    <span class="p">{</span>
        <span class="k">return</span> <span class="nv">$this</span><span class="o">-&gt;</span><span class="na">order</span><span class="p">;</span>
    <span class="p">}</span>
<span class="p">}</span>
	    </pre></div>
	  </div>
	  <p>Each listener now has access to to <tt class="docutils literal"><span class="pre">Order</span></tt> object via the <tt class="docutils literal"><span class="pre">getOrder</span></tt>
	    method.</p>
	</div>
	<div class="section" id="dispatch-the-event">
	  <h3>Dispatch the Event<a class="headerlink" href="#dispatch-the-event" title="Permalink to this headline">¶</a></h3>
	  <p>The <tt class="docutils literal"><a class="reference external" href="http://api.symfony.com/2.0/Symfony/Component/EventDispatcher/EventDispatcher.html#dispatch()" title="Symfony\Component\EventDispatcher\EventDispatcher::dispatch()"><span class="pre">dispatch()</span></a></tt>
	    method notifies all listeners of the given event. It takes two arguments: the
	    name of the event to dispatch and the <tt class="docutils literal"><span class="pre">Event</span></tt> instance to pass to each
	    listener of that event:</p>
	  <div class="highlight-php"><div class="highlight"><pre><span class="k">use</span> <span class="nx">Acme\StoreBundle\StoreEvents</span><span class="p">;</span>
<span class="k">use</span> <span class="nx">Acme\StoreBundle\Order</span><span class="p">;</span>
<span class="k">use</span> <span class="nx">Acme\StoreBundle\Event\FilterOrderEvent</span><span class="p">;</span>

<span class="c1">// the order is somehow created or retrieved</span>
<span class="nv">$order</span> <span class="o">=</span> <span class="k">new</span> <span class="nx">Order</span><span class="p">();</span>
<span class="c1">// ...</span>

<span class="c1">// create the FilterOrderEvent and dispatch it</span>
<span class="nv">$event</span> <span class="o">=</span> <span class="k">new</span> <span class="nx">FilterOrderEvent</span><span class="p">(</span><span class="nv">$order</span><span class="p">);</span>
<span class="nv">$dispatcher</span><span class="o">-&gt;</span><span class="na">dispatch</span><span class="p">(</span><span class="nx">StoreEvents</span><span class="o">::</span><span class="na">onStoreOrder</span><span class="p">,</span> <span class="nv">$event</span><span class="p">);</span>
	    </pre></div>
	  </div>
	  <p>Notice that the special <tt class="docutils literal"><span class="pre">FilterOrderEvent</span></tt> object is created and passed to
	    the <tt class="docutils literal"><span class="pre">dispatch</span></tt> method. Now, any listener to the <tt class="docutils literal"><span class="pre">store.order</span></tt> event will
	    receive the <tt class="docutils literal"><span class="pre">FilterOrderEvent</span></tt> and have access to the <tt class="docutils literal"><span class="pre">Order</span></tt> object via
	    the <tt class="docutils literal"><span class="pre">getOrder</span></tt> method:</p>
	  <div class="highlight-php"><div class="highlight"><pre><span class="c1">// some listener class that's been registered for onStoreOrder</span>
<span class="k">use</span> <span class="nx">Acme\StoreBundle\Event\FilterOrderEvent</span><span class="p">;</span>

<span class="k">public</span> <span class="k">function</span> <span class="nf">onStoreOrder</span><span class="p">(</span><span class="nx">FilterOrderEvent</span> <span class="nv">$event</span><span class="p">)</span>
<span class="p">{</span>
    <span class="nv">$order</span> <span class="o">=</span> <span class="nv">$event</span><span class="o">-&gt;</span><span class="na">getOrder</span><span class="p">();</span>
    <span class="c1">// do something to or with the order</span>
<span class="p">}</span>
	    </pre></div>
	  </div>
	</div>
      </div>
      <div class="section" id="passing-along-the-event-dispatcher-object">
	<h2>Passing along the Event Dispatcher Object<a class="headerlink" href="#passing-along-the-event-dispatcher-object" title="Permalink to this headline">¶</a></h2>
	<p>If you have a look at the <tt class="docutils literal"><span class="pre">EventDispatcher</span></tt> class, you will notice that the
	  class does not act as a Singleton (there is no <tt class="docutils literal"><span class="pre">getInstance()</span></tt> static method).
	  That is intentional, as you might want to have several concurrent event
	  dispatchers in a single PHP request. But it also means that you need a way to
	  pass the dispatcher to the objects that need to connect or notify events.</p>
	<p>The best practice is to inject the event dispatcher object into your objects,
	  aka dependency injection.</p>
	<p>You can use constructor injection:</p>
	<div class="highlight-php"><div class="highlight"><pre><span class="k">class</span> <span class="nc">Foo</span>
<span class="p">{</span>
    <span class="k">protected</span> <span class="nv">$dispatcher</span> <span class="o">=</span> <span class="k">null</span><span class="p">;</span>

    <span class="k">public</span> <span class="k">function</span> <span class="nf">__construct</span><span class="p">(</span><span class="nx">EventDispatcher</span> <span class="nv">$dispatcher</span><span class="p">)</span>
    <span class="p">{</span>
        <span class="nv">$this</span><span class="o">-&gt;</span><span class="na">dispatcher</span> <span class="o">=</span> <span class="nv">$dispatcher</span><span class="p">;</span>
    <span class="p">}</span>
<span class="p">}</span>
	  </pre></div>
	</div>
	<p>Or setter injection:</p>
	<div class="highlight-php"><div class="highlight"><pre><span class="k">class</span> <span class="nc">Foo</span>
<span class="p">{</span>
    <span class="k">protected</span> <span class="nv">$dispatcher</span> <span class="o">=</span> <span class="k">null</span><span class="p">;</span>

    <span class="k">public</span> <span class="k">function</span> <span class="nf">setEventDispatcher</span><span class="p">(</span><span class="nx">EventDispatcher</span> <span class="nv">$dispatcher</span><span class="p">)</span>
    <span class="p">{</span>
        <span class="nv">$this</span><span class="o">-&gt;</span><span class="na">dispatcher</span> <span class="o">=</span> <span class="nv">$dispatcher</span><span class="p">;</span>
    <span class="p">}</span>
<span class="p">}</span>
	  </pre></div>
	</div>
	<p>Choosing between the two is really a matter of taste. Many tend to prefer the
	  constructor injection as the objects are fully initialized at construction
	  time. But when you have a long list of dependencies, using setter injection
	  can be the way to go, especially for optional dependencies.</p>
	<div class="admonition-wrapper">
	  <div class="tip"></div><div class="admonition admonition-tip"><p class="first admonition-title">Tip</p>
	    <p class="last">If you use dependency injection like we did in the two examples above, you
	      can then use the <a class="reference external" href="https://github.com/symfony/DependencyInjection">Symfony2 Dependency Injection component</a> to elegantly
	      manage these objects.</p>
	</div></div>
      </div>
      <div class="section" id="using-event-subscribers">
	<span id="index-6"></span><h2>Using Event Subscribers<a class="headerlink" href="#using-event-subscribers" title="Permalink to this headline">¶</a></h2>
	<p>The most common way to listen to an event is to register an <em>event listener</em>
	  with the dispatcher. This listener can listen to one or more events and is
	  notified each time those events are dispatched.</p>
	<p>Another way to listen to events is via an <em>event subscriber</em>. An event
	  subscriber is a PHP class that's able to tell the dispatcher exactly which
	  events it should subscribe to. It implements the
	  <tt class="docutils literal"><a class="reference external" href="http://api.symfony.com/2.0/Symfony/Component/EventDispatcher/EventSubscriberInterface.html" title="Symfony\Component\EventDispatcher\EventSubscriberInterface"><span class="pre">EventSubscriberInterface</span></a></tt>
	  interface, which requires a single static method called
	  <tt class="docutils literal"><span class="pre">getSubscribedEvents</span></tt>. Take the following example of a subscriber that
	  subscribes to the <tt class="docutils literal"><span class="pre">core.response</span></tt> and <tt class="docutils literal"><span class="pre">store.order</span></tt> events:</p>
	<div class="highlight-php"><div class="highlight"><pre><span class="k">namespace</span> <span class="nx">Acme\StoreBundle\Event</span><span class="p">;</span>

<span class="k">use</span> <span class="nx">Symfony\Component\EventDispatcher\EventSubscriberInterface</span><span class="p">;</span>
<span class="k">use</span> <span class="nx">Symfony\Component\HttpKernel\Event\FilterResponseEvent</span><span class="p">;</span>

<span class="k">class</span> <span class="nc">StoreSubscriber</span> <span class="k">implements</span> <span class="nx">EventSubscriberInterface</span>
<span class="p">{</span>
    <span class="k">static</span> <span class="k">public</span> <span class="k">function</span> <span class="nf">getSubscribedEvents</span><span class="p">()</span>
    <span class="p">{</span>
        <span class="k">return</span> <span class="k">array</span><span class="p">(</span>
            <span class="s1">'core.response'</span> <span class="o">=&gt;</span> <span class="s1">'onCoreResponse'</span><span class="p">,</span>
            <span class="s1">'store.order'</span>   <span class="o">=&gt;</span> <span class="s1">'onStoreOrder'</span><span class="p">,</span>
        <span class="p">);</span>
    <span class="p">}</span>

    <span class="k">public</span> <span class="k">function</span> <span class="nf">onCoreResponse</span><span class="p">(</span><span class="nx">FilterResponseEvent</span> <span class="nv">$event</span><span class="p">)</span>
    <span class="p">{</span>
        <span class="c1">// ...</span>
    <span class="p">}</span>

    <span class="k">public</span> <span class="k">function</span> <span class="nf">onStoreOrder</span><span class="p">(</span><span class="nx">FilterOrderEvent</span> <span class="nv">$event</span><span class="p">)</span>
    <span class="p">{</span>
        <span class="c1">// ...</span>
    <span class="p">}</span>
<span class="p">}</span>
	  </pre></div>
	</div>
	<p>This is very similar to a listener class, except that the class itself can
	  tell the dispatcher which events it should listen to. To register a subscriber
	  with the dispatcher, use the
	  :method:<tt class="docutils literal"><span class="pre">Symfony\\Component\\EventDispatcher\\EventDispatcher::addSubscriber</span></tt>
	  method:</p>
	<div class="highlight-php"><div class="highlight"><pre><span class="k">use</span> <span class="nx">Acme\StoreBundle\Event\StoreSubscriber</span><span class="p">;</span>

<span class="nv">$subscriber</span> <span class="o">=</span> <span class="k">new</span> <span class="nx">StoreSubscriber</span><span class="p">();</span>
<span class="nv">$dispatcher</span><span class="o">-&gt;</span><span class="na">addSubscriber</span><span class="p">(</span><span class="nv">$subscriber</span><span class="p">);</span>
	  </pre></div>
	</div>
	<p>The dispatcher will automatically register the subscriber for each event
	  returned by the <tt class="docutils literal"><span class="pre">getSubscribedEvents</span></tt> method. Like with listeners, the
	  <tt class="docutils literal"><span class="pre">addSubscriber</span></tt> method has an optional second argument, which is the
	  priority that should be given to each event.</p>
      </div>
      <div class="section" id="stopping-event-flow-propagation">
	<span id="event-dispatcher-event-propagation"></span><span id="index-7"></span><h2>Stopping Event Flow/Propagation<a class="headerlink" href="#stopping-event-flow-propagation" title="Permalink to this headline">¶</a></h2>
	<p>In some cases, it may make sense for a listener to prevent any other listeners
	  from being called. In other words, the listener needs to be able to tell the
	  dispatcher to stop all propagation of the event to future listeners (i.e. to
	  not notify any more listeners). This can be accomplished from inside a
	  listener via the
	  <tt class="docutils literal"><a class="reference external" href="http://api.symfony.com/2.0/Symfony/Component/EventDispatcher/Event.html#stopPropagation()" title="Symfony\Component\EventDispatcher\Event::stopPropagation()"><span class="pre">stopPropagation()</span></a></tt> method:</p>
	<div class="highlight-php"><div class="highlight"><pre><span class="k">use</span> <span class="nx">Acme\StoreBundle\Event\FilterOrderEvent</span><span class="p">;</span>

<span class="k">public</span> <span class="k">function</span> <span class="nf">onStoreOrder</span><span class="p">(</span><span class="nx">FilterOrderEvent</span> <span class="nv">$event</span><span class="p">)</span>
<span class="p">{</span>
    <span class="c1">// ...</span>

    <span class="nv">$event</span><span class="o">-&gt;</span><span class="na">stopPropagation</span><span class="p">();</span>
<span class="p">}</span>
	  </pre></div>
	</div>
	<p>Now, any listeners to <tt class="docutils literal"><span class="pre">store.order</span></tt> that have not yet been called will <em>not</em>
	  be called.</p>
      </div>
      <div class="section" id="learn-more-from-the-cookbook">
	<h2>Learn more from the Cookbook<a class="headerlink" href="#learn-more-from-the-cookbook" title="Permalink to this headline">¶</a></h2>
	<ul class="simple">
	  <li><a class="reference internal" href="../../cookbook/event_dispatcher/class_extension.html"><em>How to extend a Class without using Inheritance</em></a></li>
	  <li><a class="reference internal" href="../../cookbook/event_dispatcher/method_behavior.html"><em>How to customize a Method Behavior without using Inheritance</em></a></li>
	</ul>
      </div>
    </div>


    

  </div>

  <div class="navigation">
    <a accesskey="P" title="Kernel" href="kernel.html">
      «&nbsp;Kernel
    </a><span class="separator">|</span>
    <a accesskey="N" title="Profiler" href="profiler.html">
      Profiler&nbsp;»
    </a>
  </div>

  <div class="box_hr"><hr></div>

</div>
