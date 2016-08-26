# pmg/queue-mapping-handler

[![Build Status](https://travis-ci.org/AgencyPMG/queue-mapping-handler.svg?branch=master)](https://travis-ci.org/AgencyPMG/queue-mapping-handler)

Provides a `PMG\Queue\MessageHandler` implementation that maps messages to
callables via a `HandlerResolver`. The default `HandlerResolver` is one that
uses an array or `ArrayAccess` and the message name.

See the `examples` directory for example usage with the queue as a whole.
