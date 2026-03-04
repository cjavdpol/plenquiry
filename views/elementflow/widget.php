<?php
/**
 * Page Enquiry widget for Elementflow (stsitebuilder)
 *
 * Renders the plenquiry module form as a native Elementflow widget with
 * full style controls in the editor panel.
 */

namespace Elementor;

if (!defined('_PS_VERSION_')) {
    exit;
}

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Core\Kits\Documents\Tabs\Global_Colors;
use Elementor\Core\Kits\Documents\Tabs\Global_Typography;
use Elementor\Includes\Widgets\Traits\Basic_Trait;

class Widget_plenquiry extends Widget_Base
{
    use Basic_Trait;

    public function get_name()
    {
        return 'plenquiry';
    }

    public function get_title()
    {
        return __('Page Enquiry', 'elementor');
    }

    public function get_categories()
    {
        return ['prestashop'];
    }

    public function get_icon()
    {
        return 'eicon-email-field';
    }

    public function get_keywords()
    {
        return ['enquiry', 'question', 'contact', 'form', 'email'];
    }

    public function get_frontend_render()
    {
        return 1;
    }

    public function is_editable()
    {
        return \Module::isInstalled('plenquiry') && \Module::isEnabled('plenquiry');
    }

    protected function register_controls()
    {
        // ── Content ─────────────────────────────────────────────────────────
        $this->start_controls_section('section_content', [
            'label' => __('Form', 'elementor'),
        ]);

        $this->add_control('show_name_field', [
            'label'   => __('Show name field', 'elementor'),
            'type'    => Controls_Manager::SWITCHER,
            'default' => 'yes',
        ]);

        $this->add_control('form_title', [
            'label'       => __('Form title', 'elementor'),
            'type'        => Controls_Manager::TEXT,
            'default'     => '',
            'placeholder' => __('Ask a question about this page', 'elementor'),
            'description' => __('Leave empty to use the default translated text.', 'elementor'),
        ]);

        $this->add_control('button_text', [
            'label'       => __('Button text', 'elementor'),
            'type'        => Controls_Manager::TEXT,
            'default'     => '',
            'placeholder' => __('Send question', 'elementor'),
        ]);

        $this->end_controls_section();

        // ── Style: Title ─────────────────────────────────────────────────────
        $this->start_controls_section('section_style_title', [
            'label' => __('Title', 'elementor'),
            'tab'   => Controls_Manager::TAB_STYLE,
        ]);

        $this->add_control('title_color', [
            'label'     => __('Color', 'elementor'),
            'type'      => Controls_Manager::COLOR,
            'global'    => ['default' => Global_Colors::COLOR_SECONDARY],
            'selectors' => [
                '{{WRAPPER}} .plenquiry-title' => 'color: {{VALUE}};',
            ],
        ]);

        $this->add_group_control(Group_Control_Typography::get_type(), [
            'name'     => 'title_typography',
            'selector' => '{{WRAPPER}} .plenquiry-title',
            'global'   => ['default' => Global_Typography::TYPOGRAPHY_SECONDARY],
        ]);

        $this->add_responsive_control('title_margin', [
            'label'      => __('Margin', 'elementor'),
            'type'       => Controls_Manager::DIMENSIONS,
            'size_units' => ['px', 'em', '%'],
            'selectors'  => [
                '{{WRAPPER}} .plenquiry-title' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
            ],
        ]);

        $this->end_controls_section();

        // ── Style: Inputs ────────────────────────────────────────────────────
        $this->start_controls_section('section_style_inputs', [
            'label' => __('Inputs', 'elementor'),
            'tab'   => Controls_Manager::TAB_STYLE,
        ]);

        $this->add_group_control(Group_Control_Typography::get_type(), [
            'name'     => 'input_typography',
            'selector' => '{{WRAPPER}} .plenquiry-form .form-control',
        ]);

        $this->add_control('input_color', [
            'label'     => __('Text color', 'elementor'),
            'type'      => Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .plenquiry-form .form-control' => 'color: {{VALUE}};',
            ],
        ]);

        $this->add_control('input_bg', [
            'label'     => __('Background', 'elementor'),
            'type'      => Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .plenquiry-form .form-control' => 'background-color: {{VALUE}};',
            ],
        ]);

        $this->add_group_control(Group_Control_Border::get_type(), [
            'name'     => 'input_border',
            'selector' => '{{WRAPPER}} .plenquiry-form .form-control',
        ]);

        $this->add_responsive_control('input_border_radius', [
            'label'      => __('Border Radius', 'elementor'),
            'type'       => Controls_Manager::DIMENSIONS,
            'size_units' => ['px', '%'],
            'selectors'  => [
                '{{WRAPPER}} .plenquiry-form .form-control' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
            ],
        ]);

        $this->add_responsive_control('input_padding', [
            'label'      => __('Padding', 'elementor'),
            'type'       => Controls_Manager::DIMENSIONS,
            'size_units' => ['px', 'em'],
            'selectors'  => [
                '{{WRAPPER}} .plenquiry-form .form-control' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
            ],
        ]);

        $this->end_controls_section();

        // ── Style: Labels ────────────────────────────────────────────────────
        $this->start_controls_section('section_style_labels', [
            'label' => __('Labels', 'elementor'),
            'tab'   => Controls_Manager::TAB_STYLE,
        ]);

        $this->add_control('label_color', [
            'label'     => __('Color', 'elementor'),
            'type'      => Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .plenquiry-form label' => 'color: {{VALUE}};',
            ],
        ]);

        $this->add_group_control(Group_Control_Typography::get_type(), [
            'name'     => 'label_typography',
            'selector' => '{{WRAPPER}} .plenquiry-form label',
        ]);

        $this->add_responsive_control('label_margin', [
            'label'      => __('Margin', 'elementor'),
            'type'       => Controls_Manager::DIMENSIONS,
            'size_units' => ['px', 'em'],
            'selectors'  => [
                '{{WRAPPER}} .plenquiry-form label' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
            ],
        ]);

        $this->end_controls_section();

        // ── Style: Button ────────────────────────────────────────────────────
        $this->start_controls_section('section_style_button', [
            'label' => __('Button', 'elementor'),
            'tab'   => Controls_Manager::TAB_STYLE,
        ]);

        $this->add_group_control(Group_Control_Typography::get_type(), [
            'name'     => 'button_typography',
            'selector' => '{{WRAPPER}} .plenquiry-submit',
        ]);

        $this->add_control('button_color', [
            'label'     => __('Text color', 'elementor'),
            'type'      => Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .plenquiry-submit' => 'color: {{VALUE}};',
            ],
        ]);

        $this->add_control('button_bg', [
            'label'     => __('Background', 'elementor'),
            'type'      => Controls_Manager::COLOR,
            'global'    => ['default' => Global_Colors::COLOR_ACCENT],
            'selectors' => [
                '{{WRAPPER}} .plenquiry-submit' => 'background-color: {{VALUE}};',
            ],
        ]);

        $this->add_control('button_bg_hover', [
            'label'     => __('Background (hover)', 'elementor'),
            'type'      => Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .plenquiry-submit:hover' => 'background-color: {{VALUE}};',
            ],
        ]);

        $this->add_group_control(Group_Control_Border::get_type(), [
            'name'     => 'button_border',
            'selector' => '{{WRAPPER}} .plenquiry-submit',
        ]);

        $this->add_responsive_control('button_border_radius', [
            'label'      => __('Border Radius', 'elementor'),
            'type'       => Controls_Manager::DIMENSIONS,
            'size_units' => ['px', '%'],
            'selectors'  => [
                '{{WRAPPER}} .plenquiry-submit' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
            ],
        ]);

        $this->add_responsive_control('button_padding', [
            'label'      => __('Padding', 'elementor'),
            'type'       => Controls_Manager::DIMENSIONS,
            'size_units' => ['px', 'em'],
            'selectors'  => [
                '{{WRAPPER}} .plenquiry-submit' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
            ],
        ]);

        $this->add_responsive_control('button_margin', [
            'label'      => __('Margin', 'elementor'),
            'type'       => Controls_Manager::DIMENSIONS,
            'size_units' => ['px', 'em'],
            'selectors'  => [
                '{{WRAPPER}} .plenquiry-submit' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
            ],
        ]);

        $this->end_controls_section();

        // ── Style: Status messages ───────────────────────────────────────────
        $this->start_controls_section('section_style_status', [
            'label' => __('Status messages', 'elementor'),
            'tab'   => Controls_Manager::TAB_STYLE,
        ]);

        $this->add_control('success_color', [
            'label'     => __('Success color', 'elementor'),
            'type'      => Controls_Manager::COLOR,
            'default'   => '#2e7d32',
            'selectors' => [
                '{{WRAPPER}} .plenquiry-success' => 'color: {{VALUE}};',
            ],
        ]);

        $this->add_control('error_color', [
            'label'     => __('Error color', 'elementor'),
            'type'      => Controls_Manager::COLOR,
            'default'   => '#c62828',
            'selectors' => [
                '{{WRAPPER}} .plenquiry-error' => 'color: {{VALUE}};',
            ],
        ]);

        $this->add_group_control(Group_Control_Typography::get_type(), [
            'name'     => 'status_typography',
            'selector' => '{{WRAPPER}} .plenquiry-status',
        ]);

        $this->end_controls_section();
    }

    protected function render()
    {
        if (!\Module::isInstalled('plenquiry') || !\Module::isEnabled('plenquiry')) {
            echo '<p style="padding:10px;border:1px solid #f00;color:#f00;">'
               . __('Page Enquiry module (plenquiry) is not installed or enabled.', 'elementor')
               . '</p>';
            return;
        }

        $module = \Module::getInstanceByName('plenquiry');
        if (!\Validate::isLoadedObject($module)) {
            return;
        }

        $settings = $this->get_settings_for_display();

        // Pass overrides so the template can use them when set
        $config = [
            'show_name_field' => $settings['show_name_field'],
            'form_title'      => $settings['form_title'],
            'button_text'     => $settings['button_text'],
        ];

        try {
            echo $module->renderWidget('renderWidget', $config);
        } catch (\Throwable $th) {
            // Silently fail in editor context
        }
    }

    protected function content_template()
    {
        ?>
        <div class="plenquiry-widget">
            <h3 class="plenquiry-title">
                <# if ( settings.form_title ) { #>{{{ settings.form_title }}}<# } else { #>Ask a question about this page<# } #>
            </h3>
            <div class="plenquiry-form">
                <# if ( settings.show_name_field === 'yes' ) { #>
                <div class="form-group">
                    <label>Your name</label>
                    <input type="text" class="form-control" placeholder="Your name" disabled>
                </div>
                <# } #>
                <div class="form-group">
                    <label>Your email address <span class="required">*</span></label>
                    <input type="email" class="form-control" placeholder="you@example.com" disabled>
                </div>
                <div class="form-group">
                    <label>Your question <span class="required">*</span></label>
                    <textarea class="form-control" rows="4" placeholder="Type your question here…" disabled></textarea>
                </div>
                <button class="btn btn-primary plenquiry-submit" disabled>
                    <# if ( settings.button_text ) { #>{{{ settings.button_text }}}<# } else { #>Send question<# } #>
                </button>
            </div>
        </div>
        <?php
    }
}
