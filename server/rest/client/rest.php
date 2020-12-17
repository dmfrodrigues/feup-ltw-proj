<?php

require_once __DIR__ . '/../../server.php';
require_once CLIENT_DIR . '/templates/common/header.php';
?>
<h2>REST API documentation</h2>

<h3>Allowed request methods</h3>

<table class="table table-striped table-bordered">
    <thead><tr><th>Request                              </th><th>GET      </th><th>POST     </th><th>PUT      </th><th>DELETE   </th></tr></thead>
    <tbody><tr><td><code>/</code> (root)                </td><td>&#10004; </td><td>&#x2716; </td><td>&#x2716; </td><td>&#x2716; </td></tr>
           <tr><td><code>login                   </code></td><td>&#10004; </td><td>&#128284;</td><td>&#x2716; </td><td>&#128284;</td></tr>
           <tr><td><code>user                    </code></td><td>&#x2716; </td><td>&#x2716; </td><td>&#10004; </td><td>&#x2716; </td></tr>
           <tr><td><code>user/&lt;id&gt;         </code></td><td>&#10004; </td><td>&#x2716; </td><td>&#10004; </td><td>&#10004; </td></tr>
           <tr><td><code>user/&lt;id&gt;/photo   </code></td><td>&#10004; </td><td>&#x2716; </td><td>&#10004; </td><td>&#10004; </td></tr>
           <tr><td><code>pet                     </code></td><td>&#128284;</td><td>&#x2716; </td><td>&#128284;</td><td>&#x2716; </td></tr>
           <tr><td><code>pet/&lt;id&gt;          </code></td><td>&#10004; </td><td>&#128284;</td><td>&#128284;</td><td>&#10004; </td></tr>
           <tr><td><code>pet/&lt;id&gt;/comments </code></td><td>&#10004; </td><td>&#x2716; </td><td>&#x2716; </td><td>&#x2716; </td></tr>
           <tr><td><code>comment/photo           </code></td><td>&#x2716; </td><td>&#x2716; </td><td>&#10004; </td><td>&#x2716; </td></tr>
           <tr><td><code>comment/&lt;id&gt;      </code></td><td>&#10004; </td><td>&#x2716; </td><td>&#10004; </td><td>&#10004; </td></tr>
           <tr><td><code>comment/&lt;id&gt;/photo</code></td><td>&#10004; </td><td>&#x2716; </td><td>&#10004; </td><td>&#10004; </td></tr></tbody>
</table>

<table class="table table-striped table-bordered">
    <thead><tr><th>Request                              </th><th>GET     </th><th>POST    </th><th>PUT     </th><th>DELETE  </th></tr></thead>
    <tbody>
        <tr>
            <td><code>/</code> (root)</td>
            <td>Get home page</td>
            <td></td>
            <td></td>
            <td></td>
        </tr>
        <tr>
            <td><code>login                   </code></td>
            <td>Get login page</td>
            <td>Login to website</td>
            <td></td>
            <td>Logout from website</td>
        </tr>
        <tr>
            <td><code>user                    </code></td>
            <td></td>
            <td></td>
            <td>Create new user</td>
            <td></td>
        </tr>
        <tr>
            <td><code>user/&lt;id&gt;         </code></td>
            <td>Get user data</td>
            <td></td>
            <td>Edit user data</td>
            <td>Delete user</td>
        </tr>
        <tr>
            <td><code>user/&lt;id&gt;/photo   </code></td>
            <td>Get profile picture</td>
            <td></td>
            <td>Add/change profile picture</td>
            <td>Delete profile picture</td>
        </tr>
        <tr>
            <td><code>pet                     </code></td>
            <td>Get all pets</td>
            <td></td>
            <td>Add new pet</td>
            <td></td>
        </tr>
        <tr>
            <td><code>pet/&lt;id&gt;          </code></td>
            <td>Get pet data</td>
            <td>?</td>
            <td>Edit pet</td>
            <td>Delete pet</td>
        </tr>
        <tr>
            <td><code>pet/&lt;id&gt;/comments </code></td>
            <td>Get comments about a pet</td>
            <td></td>
            <td></td>
            <td></td>
        </tr>
        <tr>
            <td><code>comment/photo           </code></td>
            <td></td>
            <td></td>
            <td>Add/change comment picture</td>
            <td></td>
        </tr>
        <tr>
            <td><code>comment/&lt;id&gt;      </code></td>
            <td>Get comment data</td>
            <td></td>
            <td>Edit comment</td>
            <td>Delete comment</td>
        </tr>
        <tr>
            <td><code>comment/&lt;id&gt;/photo</code></td>
            <td>Get comment picture</td>
            <td></td>
            <td>Add/edit comment picture</td>
            <td>Delete comment picture</td>
        </tr>
    </tbody>
</table>

<h3>Allowed content types for GET requests</h3>

<table class="table table-striped table-bordered">
    <thead><tr><th>Request                              </th><th>JSON     </th><th>HTML     </th><th>Redirect</th></tr></thead>
    <tbody><tr><td><code>/</code> (root)                </td><td>&#x2716; </td><td>&#10004; </td><td>&#x2716;</td></tr>
           <tr><td><code>user                    </code></td><td>&#x2716; </td><td>&#x2716; </td><td>&#x2716;</td></tr>
           <tr><td><code>user/&lt;id&gt;         </code></td><td>&#10004; </td><td>&#128284;</td><td>&#x2716;</td></tr>
           <tr><td><code>user/&lt;id&gt;/photo   </code></td><td>&#x2716; </td><td>&#x2716; </td><td>&#10004;</td></tr>
           <tr><td><code>pet                     </code></td><td>&#128284;</td><td>         </td><td>&#x2716;</td></tr>
           <tr><td><code>pet/&lt;id&gt;          </code></td><td>&#128284;</td><td>&#128284;</td><td>&#x2716;</td></tr>
           <tr><td><code>pet/&lt;id&gt;/comments </code></td><td>&#10004; </td><td>&#x2716; </td><td>&#x2716;</td></tr>
           <tr><td><code>comment/photo           </code></td><td>&#x2716; </td><td>&#x2716; </td><td>&#x2716;</td></tr>
           <tr><td><code>comment/&lt;id&gt;      </code></td><td>&#128284;</td><td>         </td><td>&#x2716;</td></tr>
           <tr><td><code>comment/&lt;id&gt;/photo</code></td><td>&#x2716; </td><td>&#x2716; </td><td>&#10004;</td></tr></tbody>
</table>

<?php
require_once CLIENT_DIR . '/templates/common/footer.php';
