<?php

/**
 * THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS
 * "AS IS" AND ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT
 * LIMITED TO, THE IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS FOR
 * A PARTICULAR PURPOSE ARE DISCLAIMED. IN NO EVENT SHALL THE COPYRIGHT
 * OWNER OR CONTRIBUTORS BE LIABLE FOR ANY DIRECT, INDIRECT, INCIDENTAL,
 * SPECIAL, EXEMPLARY, OR CONSEQUENTIAL DAMAGES (INCLUDING, BUT NOT
 * LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS OR SERVICES; LOSS OF USE,
 * DATA, OR PROFITS; OR BUSINESS INTERRUPTION) HOWEVER CAUSED AND ON ANY
 * THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT LIABILITY, OR TORT
 * (INCLUDING NEGLIGENCE OR OTHERWISE) ARISING IN ANY WAY OUT OF THE USE
 * OF THIS SOFTWARE, EVEN IF ADVISED OF THE POSSIBILITY OF SUCH DAMAGE.
 *
 * This software consists of voluntary contributions made by many individuals
 * and is licensed under the MIT license.
 */
/**
 * Captcha config.
 *
 * @author Abdul Malik Ikhsan <samsonasik@gmail.com>
 */
return [
    'learnzf2_captcha_config' => [
        0 => [
            'adapter_name' => 'Dumb',
            'options' => [
                'wordLen' => 5,
                'label' => 'Please type this word BACKWARDS',
            ],
        ],
        1 => [
            'adapter_name' => 'Figlet',
            'options' => [
                'outputWidth' => 80,
                'wordLen' => 7,
                'label' => 'Please verify you are a human',
            ],
        ],
        2 => [
            'adapter_name' => 'Image',
            'options' => [
                'font' => __DIR__.'/../assets/fonts/arial.ttf',
                'width' => 200,
                'height' => 100,
                'dotNoiseLevel' => 40,
                'lineNoiseLevel' => 3,
                'label' => 'Please verify you are a human',
            ],
        ],
    ],
];
