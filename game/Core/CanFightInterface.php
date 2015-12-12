<?php

namespace Core;

interface CanFightInterface {
	public function attack(CanFightInterface $target);
	public function takeDamage($damage);
	public function getName();
	public function getHp();
	public function isAlive();
}