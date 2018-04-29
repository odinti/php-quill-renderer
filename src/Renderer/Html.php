<?php
declare(strict_types=1);

namespace DBlackborough\Quill\Renderer;

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
     * @param array $deltas Delta objects array
     */
    public function __construct(array $deltas)
    {
        $this->html = null;

        parent::__construct($deltas);
    }

    /**
     * Generate the final HTML, calls the render method on each object
     *
     * @return string
     */
    public function render() : string
    {
        foreach ($this->deltas as $deltas) {
            $this->html .= $deltas->render();
        }

        return $this->html;
    }
}
