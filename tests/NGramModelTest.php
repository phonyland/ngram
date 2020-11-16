<?php

declare(strict_types=1);

use Phonyland\NGram\Tokenizer;
use Phonyland\NGram\NGramModel;
use Phonyland\NGram\TokenizerFilter;

test('N-Gram Model: multigram', function (): void {
    $tokenizer = new Tokenizer();
    $tokenizer->setSeparator(TokenizerFilter::ALPHABETICAL);
    $tokens = $tokenizer->tokenize(<<<EOT
        bombadil! bombadillo!
    EOT
    );

    $unigrams = NGramModel::multigram(2, $tokens);

    $expected = [
        'e'  =>
            [
                'bo' =>
                    [
                        0 =>
                            [
                                'om' => 1,
                            ],
                        1 => 0,
                    ],
                'om' =>
                    [
                        0 =>
                            [
                                'mb' => 1,
                            ],
                        1 => 0,
                    ],
                'mb' =>
                    [
                        0 =>
                            [
                                'ba' => 1,
                            ],
                        1 => 0,
                    ],
                'ba' =>
                    [
                        0 =>
                            [
                                'ad' => 1,
                            ],
                        1 => 0,
                    ],
                'ad' =>
                    [
                        0 =>
                            [
                                'di' => 1,
                            ],
                        1 => 0,
                    ],
                'di' =>
                    [
                        0 =>
                            [
                                'il' => 1,
                            ],
                        1 =>
                            [
                                'il' => 1,
                            ],
                    ],
                'il' =>
                    [
                        0 =>
                            [
                                'll' => 1,
                            ],
                        1 => 0,
                    ],
                'll' =>
                    [
                        0 => 0,
                        1 =>
                            [
                                'lo' => 1,
                            ],
                    ],
                'lo' =>
                    [
                        0 => 0,
                        1 => 0,
                    ],
            ],
        'fe' =>
            [
                'bo' => 1,
            ],
    ];

    expect($unigrams)->toBe($expected);
});
