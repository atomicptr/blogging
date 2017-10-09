# Blogging

Minimal blog extension that makes use of TYPO3s core elements.

## Download

[blogging on TER](https://extensions.typo3.org/extension/blogging/)

Or just install it via composer

```
composer require atomicptr/blogging
```

## I want...

Certain things you might want that aren't included by default because I don't consider them to be a substaintial part of a "minimal" blog extension.

### Comments

Use Disqus or something similiar.

### Posts in the List plugin should have the full page content

Using the **v:content.render** view helper from the [VHS](https://extensions.typo3.org/extension/vhs/) extension makes this fairly easy:

```html
<v:content.render pageUid="{post.uid}" />
```

## License

MIT
