<?php

namespace App\Http\Controllers;

use App\Models\Campaign;
use App\Models\Comment;
use App\Http\Requests\CommentRequest;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class CommentController extends Controller
{
    /**
     * Display comments for a campaign
     */
    public function index(Campaign $campaign): View
    {
        $comments = $campaign->comments()
            ->with('user')
            ->ordered()
            ->paginate(20);

        return view('comments.index', compact('campaign', 'comments'));
    }

    /**
     * Store a new comment
     */
    public function store(CommentRequest $request, Campaign $campaign): RedirectResponse
    {
        $comment = $campaign->comments()->create([
            'user_id' => auth()->id(),
            'content' => $request->content,
        ]);

        return redirect()
            ->route('campaigns.show', $campaign)
            ->with('success', 'Your comment has been posted successfully!')
            ->withFragment('comment-' . $comment->id);
    }

    /**
     * Update an existing comment
     */
    public function update(CommentRequest $request, Comment $comment): RedirectResponse
    {
        // Check if user can edit this comment
        if (!$comment->canBeEditedBy(auth()->user())) {
            abort(403, 'You are not authorized to edit this comment.');
        }

        $comment->update([
            'content' => $request->content,
        ]);

        $comment->markAsEdited();

        return redirect()
            ->route('campaigns.show', $comment->campaign)
            ->with('success', 'Your comment has been updated successfully!')
            ->withFragment('comment-' . $comment->id);
    }

    /**
     * Delete a comment
     */
    public function destroy(Comment $comment): RedirectResponse
    {
        // Check if user can delete this comment
        if (!$comment->canBeDeletedBy(auth()->user())) {
            abort(403, 'You are not authorized to delete this comment.');
        }

        $campaign = $comment->campaign;
        $comment->delete();

        return redirect()
            ->route('campaigns.show', $campaign)
            ->with('success', 'Comment has been deleted successfully!');
    }

    /**
     * Toggle pin status of a comment (admin only)
     */
    public function togglePin(Comment $comment): RedirectResponse
    {
        // Only admins and campaign owners can pin comments
        if (!auth()->user()->isAdmin() && $comment->campaign->user_id !== auth()->id()) {
            abort(403, 'You are not authorized to pin comments.');
        }

        $comment->update([
            'is_pinned' => !$comment->is_pinned,
        ]);

        $status = $comment->is_pinned ? 'pinned' : 'unpinned';
        
        return redirect()
            ->route('campaigns.show', $comment->campaign)
            ->with('success', "Comment has been {$status} successfully!")
            ->withFragment('comment-' . $comment->id);
    }
}
