<?php

namespace App\Http\Controllers;

use App\Models\CmsPage;
use App\Models\CmsSection;
use App\Models\CmsBlock;
use App\Models\CmsMenu;
use App\Models\CmsPost;
use App\Models\CmsCategory;
use App\Models\CmsTag;
use App\Models\CmsMedia;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class CmsController extends Controller
{
    /**
     * CMS Dashboard
     */
    public function dashboard()
    {
        $pagesCount = CmsPage::count();
        $publishedCount = CmsPage::where('is_published', true)->count();
        $blocksCount = CmsBlock::count();
        $menusCount = CmsMenu::count();
        $postsCount = CmsPost::count();
        $publishedPostsCount = CmsPost::where('status', 'published')->count();
        $categoriesCount = CmsCategory::count();
        $tagsCount = CmsTag::count();
        $mediaCount = CmsMedia::count();

        return view('cms.dashboard', compact(
            'pagesCount', 'publishedCount', 'blocksCount', 'menusCount',
            'postsCount', 'publishedPostsCount', 'categoriesCount', 'tagsCount', 'mediaCount'
        ));
    }

    /**
     * Show all pages
     */
    public function pages()
    {
        $pages = CmsPage::orderBy('order')->paginate(15);
        return view('cms.pages.index', compact('pages'));
    }

    /**
     * Create new page
     */
    public function createPage()
    {
        return view('cms.pages.create');
    }

    /**
     * Store new page
     */
    public function storePage(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:cms_pages',
            'description' => 'nullable|string',
            'seo_title' => 'nullable|string|max:255',
            'seo_description' => 'nullable|string|max:500',
            'template' => 'nullable|string|default:default',
        ]);

        $page = CmsPage::create($validated);
        return redirect()->route('cms.edit-page', $page)->with('success', 'Page created successfully!');
    }

    /**
     * Edit page
     */
    public function editPage(CmsPage $page)
    {
        $sections = $page->sections;
        $blocks = CmsBlock::all();
        return view('cms.pages.edit', compact('page', 'sections', 'blocks'));
    }

    /**
     * Update page
     */
    public function updatePage(Request $request, CmsPage $page)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:cms_pages,slug,' . $page->id,
            'description' => 'nullable|string',
            'seo_title' => 'nullable|string|max:255',
            'seo_description' => 'nullable|string|max:500',
            'template' => 'nullable|string',
            'is_published' => 'boolean',
            'is_home' => 'boolean',
        ]);

        $page->update($validated);
        return redirect()->back()->with('success', 'Page updated successfully!');
    }

    /**
     * Add section to page
     */
    public function addSection(Request $request, CmsPage $page)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'type' => 'required|in:text,image,video,slider,hero,features',
            'content' => 'nullable|string',
            'background_color' => 'nullable|string',
            'background_image' => 'nullable|string',
            'text_color' => 'nullable|string',
            'button_text' => 'nullable|string|max:255',
            'button_link' => 'nullable|url',
            'button_color' => 'nullable|string',
            'button_text_color' => 'nullable|string',
            'image_url' => 'nullable|string',
            'image_alt' => 'nullable|string',
            'heading_style' => 'nullable|in:h1,h2,h3,h4,h5,h6',
            'heading_size' => 'nullable|in:small,normal,large,xlarge',
            'padding' => 'nullable|in:none,small,standard,large',
            'text_alignment' => 'nullable|in:left,center,right',
            'layout_style' => 'nullable|in:default,grid,masonry,carousel',
            'is_visible' => 'boolean',
        ]);

        $validated['cms_page_id'] = $page->id;
        $validated['order'] = $page->sections()->count() + 1;

        CmsSection::create($validated);
        return redirect()->back()->with('success', 'Section added successfully!');
    }

    /**
     * Update section
     */
    public function updateSection(Request $request, CmsSection $section)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'type' => 'required|in:text,image,video,slider,hero,features',
            'content' => 'nullable|string',
            'background_color' => 'nullable|string',
            'background_image' => 'nullable|string',
            'text_color' => 'nullable|string',
            'button_text' => 'nullable|string|max:255',
            'button_link' => 'nullable|url',
            'button_color' => 'nullable|string',
            'button_text_color' => 'nullable|string',
            'image_url' => 'nullable|string',
            'image_alt' => 'nullable|string',
            'heading_style' => 'nullable|in:h1,h2,h3,h4,h5,h6',
            'heading_size' => 'nullable|in:small,normal,large,xlarge',
            'padding' => 'nullable|in:none,small,standard,large',
            'text_alignment' => 'nullable|in:left,center,right',
            'layout_style' => 'nullable|in:default,grid,masonry,carousel',
            'is_visible' => 'boolean',
        ]);

        $section->update($validated);
        return redirect()->back()->with('success', 'Section updated successfully!');
    }

    /**
     * Delete section
     */
    public function deleteSection(CmsSection $section)
    {
        $page = $section->page;
        $section->delete();
        return redirect()->back()->with('success', 'Section deleted successfully!');
    }

    /**
     * Reorder sections
     */
    public function reorderSections(Request $request, CmsPage $page)
    {
        $order = $request->get('order', []);
        foreach ($order as $index => $id) {
            CmsSection::where('id', $id)->update(['order' => $index + 1]);
        }
        return response()->json(['success' => true]);
    }

    /**
     * Show all reusable blocks
     */
    public function blocks()
    {
        $blocks = CmsBlock::paginate(15);
        return view('cms.blocks.index', compact('blocks'));
    }

    /**
     * Create new block
     */
    public function createBlock()
    {
        return view('cms.blocks.create');
    }

    /**
     * Store new block
     */
    public function storeBlock(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:cms_blocks',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'content' => 'required|string',
            'block_type' => 'required|in:reusable,custom',
        ]);

        CmsBlock::create($validated);
        return redirect()->route('cms.blocks')->with('success', 'Block created successfully!');
    }

    /**
     * Edit block
     */
    public function editBlock(CmsBlock $block)
    {
        return view('cms.blocks.edit', compact('block'));
    }

    /**
     * Update block
     */
    public function updateBlock(Request $request, CmsBlock $block)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'content' => 'required|string',
            'block_type' => 'required|in:reusable,custom',
        ]);

        $block->update($validated);
        return redirect()->back()->with('success', 'Block updated successfully!');
    }

    /**
     * Delete block
     */
    public function deleteBlock(CmsBlock $block)
    {
        $block->delete();
        return redirect()->route('cms.blocks')->with('success', 'Block deleted successfully!');
    }

    /**
     * Show all menus
     */
    public function menus()
    {
        $menus = CmsMenu::all();
        return view('cms.menus.index', compact('menus'));
    }

    /**
     * Edit menu
     */
    public function editMenu(CmsMenu $menu)
    {
        return view('cms.menus.edit', compact('menu'));
    }

    /**
     * Update menu
     */
    public function updateMenu(Request $request, CmsMenu $menu)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'items' => 'required|json',
        ]);

        $menu->update($validated);
        return redirect()->back()->with('success', 'Menu updated successfully!');
    }

    /**
     * Live preview of page
     */
    public function preview(CmsPage $page)
    {
        return view('cms.preview', compact('page'));
    }

    /**
     * Delete page
     */
    public function deletePage(CmsPage $page)
    {
        $page->delete();
        return redirect()->route('cms.pages')->with('success', 'Page deleted successfully!');
    }

    /**
     * Publish page
     */
    public function publishPage(CmsPage $page)
    {
        $page->update(['is_published' => true]);
        return redirect()->back()->with('success', 'Page published successfully!');
    }

    /**
     * Unpublish page
     */
    public function unpublishPage(CmsPage $page)
    {
        $page->update(['is_published' => false]);
        return redirect()->back()->with('success', 'Page unpublished successfully!');
    }

    // ===== BLOG/POST MANAGEMENT =====

    /**
     * Show all posts
     */
    public function posts()
    {
        $posts = CmsPost::with(['categories', 'tags'])->orderBy('created_at', 'desc')->paginate(15);
        return view('cms.posts.index', compact('posts'));
    }

    /**
     * Create new post
     */
    public function createPost()
    {
        $categories = CmsCategory::active()->orderBy('name')->get();
        $tags = CmsTag::orderBy('name')->get();
        return view('cms.posts.create', compact('categories', 'tags'));
    }

    /**
     * Store new post
     */
    public function storePost(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:cms_posts',
            'excerpt' => 'nullable|string|max:500',
            'content' => 'required|string',
            'featured_image' => 'nullable|string',
            'status' => 'required|in:draft,scheduled,published',
            'scheduled_at' => 'nullable|date|after:now',
            'seo_title' => 'nullable|string|max:255',
            'seo_description' => 'nullable|string|max:500',
            'seo_keywords' => 'nullable|string',
            'author_name' => 'nullable|string|max:255',
            'is_featured' => 'boolean',
            'categories' => 'array',
            'tags' => 'array',
        ]);

        if (empty($validated['slug'])) {
            $validated['slug'] = Str::slug($validated['title']);
        }

        // Handle SEO keywords
        if (!empty($validated['seo_keywords'])) {
            $validated['seo_keywords'] = array_map('trim', explode(',', $validated['seo_keywords']));
        }

        // Set published_at for published posts
        if ($validated['status'] === 'published' && empty($validated['scheduled_at'])) {
            $validated['published_at'] = now();
        } elseif ($validated['status'] === 'scheduled' && !empty($validated['scheduled_at'])) {
            $validated['published_at'] = $validated['scheduled_at'];
        }

        $post = CmsPost::create($validated);

        // Attach categories and tags
        if (!empty($validated['categories'])) {
            $post->categories()->attach($validated['categories']);
        }
        if (!empty($validated['tags'])) {
            $post->tags()->attach($validated['tags']);
        }

        return redirect()->route('cms.edit-post', $post)->with('success', 'Post created successfully!');
    }

    /**
     * Edit post
     */
    public function editPost(CmsPost $post)
    {
        $categories = CmsCategory::active()->orderBy('name')->get();
        $tags = CmsTag::orderBy('name')->get();
        $selectedCategories = $post->categories->pluck('id')->toArray();
        $selectedTags = $post->tags->pluck('id')->toArray();
        return view('cms.posts.edit', compact('post', 'categories', 'tags', 'selectedCategories', 'selectedTags'));
    }

    /**
     * Update post
     */
    public function updatePost(Request $request, CmsPost $post)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:cms_posts,slug,' . $post->id,
            'excerpt' => 'nullable|string|max:500',
            'content' => 'required|string',
            'featured_image' => 'nullable|string',
            'status' => 'required|in:draft,scheduled,published',
            'scheduled_at' => 'nullable|date|after:now',
            'seo_title' => 'nullable|string|max:255',
            'seo_description' => 'nullable|string|max:500',
            'seo_keywords' => 'nullable|string',
            'author_name' => 'nullable|string|max:255',
            'is_featured' => 'boolean',
            'categories' => 'array',
            'tags' => 'array',
        ]);

        if (empty($validated['slug'])) {
            $validated['slug'] = Str::slug($validated['title']);
        }

        // Handle SEO keywords
        if (!empty($validated['seo_keywords'])) {
            $validated['seo_keywords'] = array_map('trim', explode(',', $validated['seo_keywords']));
        }

        // Set published_at for published posts
        if ($validated['status'] === 'published' && empty($validated['scheduled_at'])) {
            $validated['published_at'] = now();
        } elseif ($validated['status'] === 'scheduled' && !empty($validated['scheduled_at'])) {
            $validated['published_at'] = $validated['scheduled_at'];
        }

        $post->update($validated);

        // Sync categories and tags
        $post->categories()->sync($validated['categories'] ?? []);
        $post->tags()->sync($validated['tags'] ?? []);

        return redirect()->back()->with('success', 'Post updated successfully!');
    }

    /**
     * Delete post
     */
    public function deletePost(CmsPost $post)
    {
        $post->delete();
        return redirect()->route('cms.posts')->with('success', 'Post deleted successfully!');
    }

    /**
     * Publish post
     */
    public function publishPost(CmsPost $post)
    {
        $post->update([
            'status' => 'published',
            'published_at' => now(),
            'scheduled_at' => null,
        ]);
        return redirect()->back()->with('success', 'Post published successfully!');
    }

    // ===== CATEGORY MANAGEMENT =====

    /**
     * Show all categories
     */
    public function categories()
    {
        $categories = CmsCategory::orderBy('order')->paginate(15);
        return view('cms.categories.index', compact('categories'));
    }

    /**
     * Store new category
     */
    public function storeCategory(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:cms_categories',
            'description' => 'nullable|string',
            'color' => 'nullable|string|max:7',
            'icon' => 'nullable|string|max:255',
            'is_active' => 'boolean',
        ]);

        if (empty($validated['slug'])) {
            $validated['slug'] = Str::slug($validated['name']);
        }

        CmsCategory::create($validated);
        return redirect()->back()->with('success', 'Category created successfully!');
    }

    /**
     * Update category
     */
    public function updateCategory(Request $request, CmsCategory $category)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:cms_categories,slug,' . $category->id,
            'description' => 'nullable|string',
            'color' => 'nullable|string|max:7',
            'icon' => 'nullable|string|max:255',
            'is_active' => 'boolean',
        ]);

        if (empty($validated['slug'])) {
            $validated['slug'] = Str::slug($validated['name']);
        }

        $category->update($validated);
        return redirect()->back()->with('success', 'Category updated successfully!');
    }

    /**
     * Delete category
     */
    public function deleteCategory(CmsCategory $category)
    {
        $category->delete();
        return redirect()->back()->with('success', 'Category deleted successfully!');
    }

    // ===== TAG MANAGEMENT =====

    /**
     * Show all tags
     */
    public function tags()
    {
        $tags = CmsTag::orderBy('name')->paginate(15);
        return view('cms.tags.index', compact('tags'));
    }

    /**
     * Store new tag
     */
    public function storeTag(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:cms_tags',
            'color' => 'nullable|string|max:7',
        ]);

        if (empty($validated['slug'])) {
            $validated['slug'] = Str::slug($validated['name']);
        }

        CmsTag::create($validated);
        return redirect()->back()->with('success', 'Tag created successfully!');
    }

    /**
     * Update tag
     */
    public function updateTag(Request $request, CmsTag $tag)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:cms_tags,slug,' . $tag->id,
            'color' => 'nullable|string|max:7',
        ]);

        if (empty($validated['slug'])) {
            $validated['slug'] = Str::slug($validated['name']);
        }

        $tag->update($validated);
        return redirect()->back()->with('success', 'Tag updated successfully!');
    }

    /**
     * Delete tag
     */
    public function deleteTag(CmsTag $tag)
    {
        $tag->delete();
        return redirect()->back()->with('success', 'Tag deleted successfully!');
    }

    // ===== MEDIA LIBRARY MANAGEMENT =====

    /**
     * Show media library
     */
    public function media()
    {
        $media = CmsMedia::orderBy('created_at', 'desc')->paginate(20);
        $folders = CmsMedia::distinct('folder')->pluck('folder');
        return view('cms.media.index', compact('media', 'folders'));
    }

    /**
     * Upload media files
     */
    public function uploadMedia(Request $request)
    {
        $request->validate([
            'files' => 'required|array',
            'files.*' => 'required|file|max:51200', // 50MB max
            'folder' => 'nullable|string|max:255',
        ]);

        $uploadedFiles = [];
        $folder = $request->get('folder', 'general');

        foreach ($request->file('files') as $file) {
            $originalName = $file->getClientOriginalName();
            $fileName = time() . '_' . Str::slug(pathinfo($originalName, PATHINFO_FILENAME)) . '.' . $file->getClientOriginalExtension();

            // Store file
            $path = $file->storeAs('uploads/' . $folder, $fileName, 'public');

            // Get dimensions for images
            $dimensions = null;
            if (str_starts_with($file->getMimeType(), 'image/')) {
                $imageSize = getimagesize($file->getRealPath());
                if ($imageSize) {
                    $dimensions = [
                        'width' => $imageSize[0],
                        'height' => $imageSize[1],
                    ];
                }
            }

            $media = CmsMedia::create([
                'name' => pathinfo($originalName, PATHINFO_FILENAME),
                'file_name' => $fileName,
                'mime_type' => $file->getMimeType(),
                'path' => $path,
                'file_size' => $file->getSize(),
                'dimensions' => $dimensions,
                'folder' => $folder,
            ]);

            $uploadedFiles[] = $media;
        }

        return response()->json([
            'success' => true,
            'files' => $uploadedFiles,
            'message' => count($uploadedFiles) . ' file(s) uploaded successfully!'
        ]);
    }

    /**
     * Update media metadata
     */
    public function updateMedia(Request $request, CmsMedia $media)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'alt_text' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'folder' => 'required|string|max:255',
        ]);

        $media->update($validated);
        return response()->json(['success' => true, 'message' => 'Media updated successfully!']);
    }

    /**
     * Delete media
     */
    public function deleteMedia(CmsMedia $media)
    {
        // Delete file from storage
        Storage::disk($media->disk)->delete($media->path);

        // Delete thumbnail if exists
        if (str_starts_with($media->mime_type, 'image/')) {
            $thumbnailPath = str_replace('/uploads/', '/uploads/thumbnails/', $media->path);
            Storage::disk($media->disk)->delete($thumbnailPath);
        }

        $media->delete();
        return response()->json(['success' => true, 'message' => 'Media deleted successfully!']);
    }

    /**
     * Get media by folder
     */
    public function getMediaByFolder(Request $request)
    {
        $folder = $request->get('folder', 'general');
        $media = CmsMedia::where('folder', $folder)->orderBy('created_at', 'desc')->paginate(20);
        return response()->json($media);
    }
}
