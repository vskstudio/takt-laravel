# vskstudio/takt-laravel

## 0.5.1

### Patch Changes

- `TAKT_ENDPOINT` no longer means two different things depending on the code path.
  It fed both the browser snippet, which expects the full collect URL, and the
  server-side sender, which expects an origin it appends `/api/event` to — so the
  shipped default (`https://taktlytics.com`) made the browser post to the service
  root, while the full URL form (`https://taktlytics.com/api/event`) made the
  server post to `/api/event/api/event`. Both forms are now normalised on read to
  whatever each path needs, so every existing configuration keeps working and both
  paths agree. A value carrying any other path (a same-origin first-party proxy
  such as `/collect`) is still used verbatim.
- Docs: the accepted `endpoint` forms are spelled out in the README and the
  published config file; the container bindings are documented with their real
  scope (`SnippetRenderer` is a singleton, `Takt` is `scoped`, not a singleton);
  the `Takt` facade docblock now carries the full `event()`/`pageview()`
  signatures.

Releases before 0.5.1 are documented in the repository's git tags.
