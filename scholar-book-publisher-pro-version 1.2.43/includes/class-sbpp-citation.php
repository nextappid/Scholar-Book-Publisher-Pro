<?php
/**
 * Citation Generator for Scholar Book Publisher Pro
 *
 * @package Scholar_Book_Publisher
 */

if (!defined('ABSPATH')) {
    exit;
}

class SBPP_Citation_Generator {

    /**
     * Parses an author string or array into an array of author objects
     *
     * @param string|array $authors_input Comma separated string or array of strings/arrays
     * @return array Array of associative arrays with 'first', 'last', 'initials'
     */
    public static function parse_authors_to_parts($authors_input) {
        $author_strings = [];

        // Normalize input into an array of full name strings
        if (is_array($authors_input)) {
            foreach ($authors_input as $author) {
                if (is_array($author)) {
                    // Handle existing metadata format ['first_name' => '...', 'last_name' => '...']
                    $first = isset($author['first_name']) ? trim($author['first_name']) : '';
                    $last = isset($author['last_name']) ? trim($author['last_name']) : '';
                    if ($first || $last) {
                        $author_strings[] = trim($first . ' ' . $last);
                    }
                } else {
                    // Split comma-separated within array just in case
                    $parts = array_map('trim', explode(',', $author));
                    foreach ($parts as $p) {
                        if (!empty($p)) $author_strings[] = $p;
                    }
                }
            }
        } elseif (is_string($authors_input)) {
            $parts = array_map('trim', explode(',', $authors_input));
            foreach ($parts as $p) {
                if (!empty($p)) $author_strings[] = $p;
            }
        }

        $parsed_authors = [];
        foreach ($author_strings as $name_str) {
            $words = explode(' ', trim($name_str));
            $last = array_pop($words);
            $first = implode(' ', $words);
            
            // Get initials from first name
            $initials = '';
            if (!empty($first)) {
                $first_words = explode(' ', $first);
                foreach ($first_words as $w) {
                    if (!empty($w)) {
                        $initials .= mb_substr($w, 0, 1) . '.';
                    }
                }
            }

            $parsed_authors[] = [
                'first' => $first,
                'last' => $last,
                'initials' => $initials
            ];
        }

        return $parsed_authors;
    }

    /**
     * Format authors based on requested style (apa, mla, chicago)
     *
     * @param array $authors Output from parse_authors_to_parts
     * @param string $style 'apa', 'mla', or 'chicago'
     * @return string Formatted authors string
     */
    public static function format_authors($authors, $style = 'apa') {
        if (empty($authors)) {
            return 'Unknown Author';
        }

        $count = count($authors);
        $formatted = [];

        if ($style === 'apa') {
            // APA: Last1, Initial1., & Last2, Initial2.
            foreach ($authors as $index => $a) {
                $name = $a['last'];
                if (!empty($a['initials'])) {
                    $name .= ', ' . $a['initials'];
                }
                
                if ($count > 1 && $index === $count - 1) {
                    $formatted[] = '& ' . $name;
                } else {
                    $formatted[] = $name;
                }
            }
            return implode(', ', $formatted);
        } 
        
        elseif ($style === 'mla') {
            // MLA: Last1, First1, and First2 Last2.
            if ($count === 1) {
                $name = $authors[0]['last'];
                if (!empty($authors[0]['first'])) {
                    $name .= ', ' . $authors[0]['first'];
                }
                return $name;
            } elseif ($count === 2) {
                $name1 = $authors[0]['last'] . (!empty($authors[0]['first']) ? ', ' . $authors[0]['first'] : '');
                $name2 = (!empty($authors[1]['first']) ? $authors[1]['first'] . ' ' : '') . $authors[1]['last'];
                return $name1 . ', and ' . $name2;
            } else {
                $name = $authors[0]['last'];
                if (!empty($authors[0]['first'])) {
                    $name .= ', ' . $authors[0]['first'];
                }
                return $name . ', et al.';
            }
        } 
        
        elseif ($style === 'chicago') {
            // Chicago: Last1, First1, and First2 Last2. (if >3 use et al.)
            if ($count === 1) {
                $name = $authors[0]['last'];
                if (!empty($authors[0]['first'])) {
                    $name .= ', ' . $authors[0]['first'];
                }
                return $name;
            } elseif ($count === 2) {
                $name1 = $authors[0]['last'] . (!empty($authors[0]['first']) ? ', ' . $authors[0]['first'] : '');
                $name2 = (!empty($authors[1]['first']) ? $authors[1]['first'] . ' ' : '') . $authors[1]['last'];
                return $name1 . ', and ' . $name2;
            } elseif ($count === 3) {
                $name1 = $authors[0]['last'] . (!empty($authors[0]['first']) ? ', ' . $authors[0]['first'] : '');
                $name2 = (!empty($authors[1]['first']) ? $authors[1]['first'] . ' ' : '') . $authors[1]['last'];
                $name3 = (!empty($authors[2]['first']) ? $authors[2]['first'] . ' ' : '') . $authors[2]['last'];
                return $name1 . ', ' . $name2 . ', and ' . $name3;
            } else {
                $name = $authors[0]['last'];
                if (!empty($authors[0]['first'])) {
                    $name .= ', ' . $authors[0]['first'];
                }
                return $name . ', et al.';
            }
        }

        return '';
    }

    /**
     * Get all citation formats for a given post
     */
    public static function get_citations($post_id) {
        $book_authors_meta = get_post_meta($post_id, '_sbpp_authors', true);
        $chapter_title = get_post_meta($post_id, '_sbpp_chapter_title', true);
        $chapter_authors_meta = get_post_meta($post_id, '_sbpp_chapter_authors', true);
        
        $year = get_post_meta($post_id, '_sbpp_book_year', true);
        if (empty($year)) $year = get_the_date('Y', $post_id);
        
        $publisher = get_post_meta($post_id, '_sbpp_book_publisher', true) ?: 'Unknown Publisher';
        $city = get_post_meta($post_id, '_sbpp_publisher_city', true) ?: '';
        $editor = get_post_meta($post_id, '_sbpp_book_editor', true);
        $url = get_permalink($post_id);
        
        $book_title = get_the_title($post_id);
        $subtitle = get_post_meta($post_id, '_sbpp_book_subtitle', true);
        $subtitle = trim((string)$subtitle);
        $italic_book_title = !empty($subtitle) ? "<i>{$book_title}: {$subtitle}</i>" : "<i>{$book_title}</i>";
        
        $authors_meta = !empty($chapter_authors_meta) ? $chapter_authors_meta : $book_authors_meta;
        $authors_parsed = self::parse_authors_to_parts($authors_meta);
        
        $apa_authors = self::format_authors($authors_parsed, 'apa');
        $mla_authors = self::format_authors($authors_parsed, 'mla');
        $chi_authors = self::format_authors($authors_parsed, 'chicago');

        $is_chapter = !empty($chapter_title);
        
        // Start page / end page logic
        $pages = '';
        if ($is_chapter) {
            $start_page = get_post_meta($post_id, '_sbpp_chapter_start_page', true);
            $end_page = get_post_meta($post_id, '_sbpp_chapter_end_page', true);
            if ($start_page && $end_page) {
                $pages = $start_page . '-' . $end_page;
            } elseif ($start_page) {
                $pages = $start_page;
            }
        }

        $citations = [];

        if ($is_chapter) {
            // Book Section Format
            $editor_str = $editor ? " Dalam {$editor} (Ed.)," : " Dalam";
            $pages_str = $pages ? " (hlm. {$pages})" : "";
            $citations['apa'] = "{$apa_authors}. ({$year}). {$chapter_title}.{$editor_str} {$italic_book_title}{$pages_str}. {$publisher}. {$url}";
            
            $editor_mla = $editor ? ", diedit oleh {$editor}" : "";
            $pages_mla = $pages ? ", hlm. {$pages}" : "";
            $citations['mla'] = "{$mla_authors}. \"{$chapter_title}.\" {$italic_book_title}{$editor_mla}, {$publisher}, {$year}{$pages_mla}.";
            
            $editor_chi = $editor ? ", diedit oleh {$editor}" : "";
            $pages_chi = $pages ? ", {$pages}" : "";
            $city_str = $city ? "{$city}: " : "";
            $citations['chicago'] = "{$chi_authors}. \"{$chapter_title}.\" Dalam {$italic_book_title}{$editor_chi}{$pages_chi}. {$city_str}{$publisher}, {$year}.";
        } else {
            // Book Format
            $citations['apa'] = "{$apa_authors}. ({$year}). {$italic_book_title}. {$publisher}. {$url}";
            
            $citations['mla'] = "{$mla_authors}. {$italic_book_title}. {$publisher}, {$year}.";
            
            $city_str = $city ? "{$city}: " : "";
            $citations['chicago'] = "{$chi_authors}. {$italic_book_title}. {$city_str}{$publisher}, {$year}.";
        }

        return [
            'html' => $citations,
            'raw' => [
                'type' => $is_chapter ? 'CHAP' : 'BOOK',
                'authors' => $authors_parsed,
                'year' => $year,
                'title' => $is_chapter ? $chapter_title : $book_title,
                'book_title' => $is_chapter ? $book_title : '',
                'publisher' => $publisher,
                'city' => $city,
                'url' => $url,
                'pages' => $pages
            ]
        ];
    }
}
