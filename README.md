A simple unique token utility to prevent cross-site resource forging (CSRF) attacks.

Installation
============

```bash
composer require ob-ivan/sd-csrf
```

Usage
=====
The general use case may be outlined as follows:
- A controller requests a token, which csrf manager generates and stores in session data under some reconstructable key.
- A view prints token value to a hidden input.
- User submits a form, which brings token value to form processing controller.
- That second controller reconstructs the key and asks manager to verify the token value,
and rejects the form if the value differs.

This reduces chances that the said form would be sent without user's consent.

Please note that a manager instance may be either provided with dependency injection container,
or instantiated at call time as it is currently stateless (which is not guaranteed to hold in future, though).

A sample code would be as follows:

```php
use SD\Csrf\Manager;

class CommentController {
    public function getFormAction($postId) {
        return $this->render('form.twig', [
            'postId' => $postId,
            'token' => $this->getCsrfManager()->get($this->getTokenKey($postId)),
        ]);
    }

    public function postFormAction($request) {
        $postId = $request->post->get('postId');
        $tokenValue = $request->post->get('token');
        if (!$this->getCsrfManager()->verify($this->getTokenKey($postId), $tokenValue)) {
            return $this->errorResponse('Csrf token verification failed');
        }
        // ...save comment...
    }

    private function getTokenKey($postId) {
        return "post_comment_token_$postId";
    }
}
```

The corresponding view code:

```twig
<form action="POST">
    <input type="hidden" name="postId" value="{{ postId }}"/>
    <input type="hidden" name="token" value="{{ token.value }}"/>
    <textarea name="comment"></textarea>
    <button type="submit>Send it already</button>
</form>
```
