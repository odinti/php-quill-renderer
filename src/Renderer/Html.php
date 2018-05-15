<?php
declare(strict_types=1);

namespace DBlackborough\Quill\Renderer;

use DBlackborough\Quill\Delta\Html\Delta;

/**
 * Quill renderer, iterates over the Deltas array from the parser calling the render method
 *
 * @author Dean Blackborough <dean@g3d-development.com>
 * @copyright Dean Blackborough
 * @license https://github.com/deanblackborough/php-quill-renderer/blob/master/LICENSE
 */
class Html extends Render
{
    /**
     * The generated HTML, string generated by the render method from the content array
     *
     * @var string
     */
    protected $html;

    /**
     * Renderer constructor.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Generate the final HTML, calls the render method on each object
     *
     * @return string
     */
    public function render(): string
    {
        $this->html = '';

        $block_open = false;

        foreach ($this->deltas as $i => $delta) {
            if ($delta->displayType() === Delta::DISPLAY_INLINE && $block_open === false) {
                $block_open = true;
                $this->html .= '<p>';
            }

            if ($delta->isChild() === true && $delta->isFirstChild() === true) {

                if ($block_open === true && $this->deltas[$i - 1]->displayType() === Delta::DISPLAY_INLINE) {
                    $this->html .= '</p>';
                }

                $this->html .= '<' . $delta->parentTag() . '>';
            }

            $this->html .= $delta->render();

            if ($delta->displayType() === Delta::DISPLAY_INLINE && $block_open === true && $delta->close() === true) {
                $this->html .= '</p>';
                $block_open = false;
            }

            if ($delta->isChild() === true && $delta->isLastChild() === true) {
                $this->html .= '</' . $delta->parentTag() . '>';
            }

            if ($i === count($this->deltas) - 1 && $delta->displayType() === Delta::DISPLAY_INLINE && $block_open === true) {
                $this->html .= '</p>';
            }
        }

        return $this->html;
    }
}
